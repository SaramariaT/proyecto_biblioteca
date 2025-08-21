<?php

namespace App\Controllers;

use App\Models\PrestamoModel;
use App\Models\EjemplarModel;
use CodeIgniter\Controller;

class Prestamos extends Controller
{
    protected $modelo;
    protected $ejemplarModel;

    public function __construct()
    {
        $this->modelo = new PrestamoModel();
        $this->ejemplarModel = new EjemplarModel();
    }

    // Ruta: /prestamos
    public function index()
    {
        $data['prestamos'] = $this->modelo->obtenerTodos();
        return view('prestamos/listado', $data);
    }

    // Ruta: /prestamos/nuevo
    public function nuevo()
    {
        $db = \Config\Database::connect();
        $data['usuarios'] = $db->query("SELECT id, nombre FROM usuarios_biblioteca")->getResultArray();
        $data['ejemplares'] = $db->query("
            SELECT e.id, e.codigo_ejemplar, l.titulo 
            FROM ejemplares e
            JOIN libros l ON e.id_libro = l.id
            WHERE e.estado = 'Disponible'
            ORDER BY l.titulo ASC, e.codigo_ejemplar ASC
        ")->getResultArray();

        return view('prestamos/formulario', $data);
    }

    // Ruta: /prestamos/guardar
    public function guardar()
    {
        $idEjemplar = $this->request->getPost('id_ejemplar');

        // Crear el préstamo
        $this->modelo->crear(
            $idEjemplar,
            $this->request->getPost('id_usuario'),
            $this->request->getPost('fecha_prestamo'),
            $this->request->getPost('fecha_devolucion')
        );

        // Marcar ejemplar como Prestado
        $this->ejemplarModel->update($idEjemplar, [
            'estado' => 'Prestado'
        ]);

        return redirect()->to(base_url('prestamos'));
    }

    // Ruta: /prestamos/devolver/{id}
    public function devolver($id)
    {
        // Marcar préstamo como devuelto con retraso si aplica
        $this->modelo->marcarDevueltoConRetraso($id);

        // Obtener el préstamo para saber qué ejemplar actualizar
        $prestamo = $this->modelo->find($id);

        // Marcar ejemplar como disponible
        $this->ejemplarModel->update($prestamo['id_ejemplar'], [
            'estado' => 'Disponible'
        ]);

        return redirect()->to(base_url('prestamos'));
    }

    // Ruta: /prestamos/vencidos
    public function vencidos()
    {
        $vencidos = $this->modelo
            ->where('estado', 'Prestado')
            ->where('fecha_devolucion <', date('Y-m-d'))
            ->findAll();

        return view('prestamos/vencidos', ['prestamos' => $vencidos]);
    }

    public function editar($id)
    {
        $prestamo = $this->modelo->find($id);

        if (!$prestamo) {
            return redirect()->to(base_url('prestamos'))->with('error', 'Préstamo no encontrado');
        }

        $db = \Config\Database::connect();
        $data['prestamo'] = $prestamo;
        $data['usuarios'] = $db->query("SELECT id, nombre FROM usuarios_biblioteca")->getResultArray();
        $data['ejemplares'] = $db->query("
            SELECT e.id, e.codigo_ejemplar, l.titulo 
            FROM ejemplares e
            JOIN libros l ON e.id_libro = l.id
            ORDER BY l.titulo ASC, e.codigo_ejemplar ASC
        ")->getResultArray();

        return view('prestamos/formulario_editar', $data);
    }

    public function actualizar($id)
    {
        $estado = ucfirst(strtolower($this->request->getPost('estado')));
        $fechaDevolucion = $this->request->getPost('fecha_devolucion');
        $fechaReal = $this->request->getPost('fecha_real_devolucion');
        $retrasoManual = $this->request->getPost('retraso') === '1';

        // Determinar si hay retraso automáticamente
        $retraso = false;
        if ($estado === 'Devuelto' && $fechaReal && $fechaReal > $fechaDevolucion) {
            $retraso = true;
        } elseif ($retrasoManual) {
            $retraso = true;
        }

        // Determinar progreso
        $progreso = ($estado === 'Devuelto') ? 'completado' : 'en curso';

        $datos = [
            'id_usuario' => $this->request->getPost('id_usuario'),
            'id_ejemplar' => $this->request->getPost('id_ejemplar'),
            'fecha_prestamo' => $this->request->getPost('fecha_prestamo'),
            'fecha_devolucion' => $fechaDevolucion,
            'fecha_real_devolucion' => $fechaReal ?: null,
            'estado' => $estado,
            'retraso' => $retraso,
            'progreso' => $progreso
        ];

        $this->modelo->update($id, $datos);

        return redirect()->to(base_url('prestamos'));
    }



}

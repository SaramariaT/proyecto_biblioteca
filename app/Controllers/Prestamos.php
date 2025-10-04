<?php

namespace App\Controllers;

use App\Models\PrestamoModel;
use App\Models\LibroModel;
use CodeIgniter\Controller;

class Prestamos extends Controller
{
    protected $modelo;
    protected $libroModel;

    public function __construct()
    {
        $this->modelo = new PrestamoModel();
        $this->libroModel = new LibroModel();
    }

    public function index()
    {
        $data['prestamos'] = $this->modelo->obtenerTodos();
        return view('prestamos/listado', $data);
    }

    public function nuevo()
    {
        $db = \Config\Database::connect();
        $data['usuarios'] = $db->query("SELECT id, nombre FROM usuarios_biblioteca")->getResultArray();
        $data['libros'] = $db->query("
            SELECT id, codigo, titulo 
            FROM libros 
            WHERE estado = 'Disponible'
            ORDER BY codigo ASC
        ")->getResultArray();

        return view('prestamos/formulario', $data);
    }

    public function guardar()
    {
        $idLibro = $this->request->getPost('id_libro');

        // Validar disponibilidad
        $libro = $this->libroModel->find($idLibro);
        if (!$libro || $libro['estado'] !== 'Disponible') {
            return redirect()->back()->with('error', 'El libro no está disponible.');
        }

        // Crear el préstamo
        $this->modelo->crear(
            $idLibro,
            $this->request->getPost('id_usuario'),
            $this->request->getPost('fecha_prestamo') ?: null,
            $this->request->getPost('fecha_devolucion') ?: null
        );

        // Marcar libro como Prestado
        $this->libroModel->update($idLibro, ['estado' => 'Prestado']);

        return redirect()->to(base_url('prestamos'))->with('mensaje', 'Préstamo registrado correctamente');
    }

    public function devolver($id)
    {
        $prestamo = $this->modelo->marcarDevueltoConRetraso($id);
        if ($prestamo) {
            $this->libroModel->update($prestamo['id_libro'], ['estado' => 'Disponible']);
        }

        return redirect()->to(base_url('prestamos'))->with('mensaje', 'Préstamo devuelto correctamente');
    }

    public function vencidos()
    {
        $data['prestamos'] = $this->modelo->obtenerPrestamosActivos(); // Podés filtrar vencidos en el modelo si querés
        return view('prestamos/vencidos', $data);
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
        $data['libros'] = $db->query("SELECT id, codigo, titulo FROM libros ORDER BY codigo ASC")->getResultArray();

        return view('prestamos/formulario_editar', $data);
    }

    public function actualizar($id)
    {
        $estado = ucfirst(strtolower($this->request->getPost('estado')));
        $fechaDevolucion = $this->request->getPost('fecha_devolucion');
        $fechaReal = $this->request->getPost('fecha_real_devolucion');
        $retrasoManual = $this->request->getPost('retraso') === '1';

        $retraso = false;
        if ($estado === 'Devuelto') {
            if (!$fechaReal) {
                $fechaReal = date('Y-m-d');
            }
            if ($fechaReal > $fechaDevolucion) {
                $retraso = true;
            }
        } elseif ($retrasoManual) {
            $retraso = true;
        }

        $progreso = ($estado === 'Devuelto') ? 'completado' : 'en curso';

        $datos = [
            'id_usuario' => $this->request->getPost('id_usuario'),
            'id_libro' => $this->request->getPost('id_libro'),
            'fecha_prestamo' => $this->request->getPost('fecha_prestamo'),
            'fecha_devolucion' => $fechaDevolucion,
            'fecha_real_devolucion' => $fechaReal ?: null,
            'estado' => $estado,
            'retraso' => $retraso,
            'progreso' => $progreso
        ];

        $this->modelo->update($id, $datos);

        // Liberar libro si el préstamo fue devuelto
        if ($estado === 'Devuelto') {
            $this->libroModel->update($datos['id_libro'], ['estado' => 'Disponible']);
        }

        return redirect()->to(base_url('prestamos'))->with('mensaje', 'Préstamo actualizado correctamente');
    }
}

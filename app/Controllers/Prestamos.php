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

    public function index()
    {
        $data['prestamos'] = $this->modelo->obtenerTodos();
        return view('prestamos/listado', $data);
    }

    public function nuevo()
    {
        $db = \Config\Database::connect();
        $data['usuarios'] = $db->query("SELECT id, nombre FROM usuarios_biblioteca")->getResultArray();
        $data['ejemplares'] = $db->query("
            SELECT e.id, e.codigo_ejemplar, l.titulo 
            FROM ejemplares e
            JOIN libros l ON e.id_libro = l.id
            WHERE e.estado = 'Disponible'
            ORDER BY 
                CAST(SUBSTRING(e.codigo_ejemplar, 4, 3) AS UNSIGNED) ASC,
                CAST(SUBSTRING_INDEX(e.codigo_ejemplar, '-', -1) AS UNSIGNED) ASC
        ")->getResultArray();

        return view('prestamos/formulario', $data);
    }

    public function guardar()
    {
        $idEjemplar = $this->request->getPost('id_ejemplar');

        // Validar disponibilidad
        $ejemplar = $this->ejemplarModel->find($idEjemplar);
        if (!$ejemplar || $ejemplar['estado'] !== 'Disponible') {
            return redirect()->back()->with('error', 'El ejemplar no está disponible.');
        }

        // Crear el préstamo (si no se pasa fecha_devolucion, el modelo la calcula)
        $this->modelo->crear(
            $idEjemplar,
            $this->request->getPost('id_usuario'),
            $this->request->getPost('fecha_prestamo') ?: null,
            $this->request->getPost('fecha_devolucion') ?: null
        );

        // Marcar ejemplar como Prestado
        $this->ejemplarModel->update($idEjemplar, ['estado' => 'Prestado']);

        return redirect()->to(base_url('prestamos'))->with('mensaje', 'Préstamo registrado correctamente');
    }

    public function devolver($id)
    {
        $prestamo = $this->modelo->marcarDevueltoConRetraso($id);
        if ($prestamo) {
            $this->ejemplarModel->update($prestamo['id_ejemplar'], ['estado' => 'Disponible']);
        }

        return redirect()->to(base_url('prestamos'))->with('mensaje', 'Préstamo devuelto correctamente');
    }

    public function vencidos()
    {
        $db = \Config\Database::connect();

        $vencidos = $db->table('prestamos p')
            ->select("
                p.*,
                u.nombre AS usuario,
                e.codigo_ejemplar AS ejemplar,
                l.titulo AS libro,
                DATEDIFF(CURDATE(), p.fecha_devolucion) AS dias_retraso
            ")
            ->join('usuarios_biblioteca u', 'p.id_usuario = u.id')
            ->join('ejemplares e', 'p.id_ejemplar = e.id')
            ->join('libros l', 'e.id_libro = l.id')
            ->where('p.estado', 'Prestado')
            ->where('p.fecha_devolucion <', date('Y-m-d'))
            ->orderBy('dias_retraso', 'DESC')
            ->get()
            ->getResultArray();

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
            ORDER BY 
                CAST(SUBSTRING(e.codigo_ejemplar, 4, 3) AS UNSIGNED) ASC,
                CAST(SUBSTRING_INDEX(e.codigo_ejemplar, '-', -1) AS UNSIGNED) ASC
        ")->getResultArray();

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
                $fechaReal = date('Y-m-d'); // asigna automáticamente si no se puso
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
            'id_ejemplar' => $this->request->getPost('id_ejemplar'),
            'fecha_prestamo' => $this->request->getPost('fecha_prestamo'),
            'fecha_devolucion' => $fechaDevolucion,
            'fecha_real_devolucion' => $fechaReal ?: null,
            'estado' => $estado,
            'retraso' => $retraso,
            'progreso' => $progreso
        ];

        $this->modelo->update($id, $datos);

        // Liberar ejemplar si el préstamo fue devuelto
        if ($estado === 'Devuelto') {
            $this->ejemplarModel->update($datos['id_ejemplar'], ['estado' => 'Disponible']);
        }

        return redirect()->to(base_url('prestamos'))->with('mensaje', 'Préstamo actualizado correctamente');
    }
}

<?php

namespace App\Controllers;

use App\Models\PrestamoModel;
use App\Models\LibroModel;
use App\Models\UsuarioBibliotecaModel;
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
        if (!tienePermiso('ver', 'prestamos') && !tienePermiso('ver_historial', 'prestamos')) {
            return redirect()->to('/panel')->with('error', 'No tienes permiso para ver préstamos.');
        }

        $db = \Config\Database::connect();
        $busqueda = $this->request->getGet('busqueda');
        $rol = session()->get('rol_usuario');
        $carne = session()->get('usuario');

        $condiciones = [];

        // Si es alumno, filtrar por su id_usuario
        if ($rol === 'Alumno') {
            $perfilModel = new UsuarioBibliotecaModel();
            $perfil = $perfilModel->where('carne', $carne)->first();

            if ($perfil) {
                $idUsuario = $perfil['id'];
                $condiciones[] = "p.id_usuario = {$idUsuario}";
            } else {
                $condiciones[] = "1 = 0"; // sin perfil, no mostrar nada
            }
        }

        // Si hay búsqueda, agregar condiciones
        if (!empty($busqueda)) {
        $condiciones[] = "(u.nombre LIKE '%{$busqueda}%' OR 
                        l.titulo LIKE '%{$busqueda}%' OR 
                        p.estado LIKE '%{$busqueda}%' OR 
                        p.progreso LIKE '%{$busqueda}%')";
        }

        $sql = "
            SELECT 
                p.*, 
                u.nombre AS usuario, 
                CONCAT(l.codigo, ' - ', l.numero_ejemplar, ' - ', l.titulo) AS libro 
            FROM prestamos p
            JOIN usuarios_biblioteca u ON u.id = p.id_usuario
            JOIN libros l ON l.id = p.id_libro
        ";

        if (!empty($condiciones)) {
            $sql .= " WHERE " . implode(" AND ", $condiciones);
        }

        $sql .= " ORDER BY p.fecha_prestamo DESC";

        $data['prestamos'] = $db->query($sql)->getResultArray();
        $data['busqueda'] = $busqueda;

        return view('prestamos/listado', $data);
    }

    // Los demás métodos (nuevo, guardar, devolver, vencidos, editar, actualizar) se mantienen igual
    // No es necesario modificarlos para este comportamiento

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

        $libro = $this->libroModel->find($idLibro);
        if (!$libro || $libro['estado'] !== 'Disponible') {
            return redirect()->back()->with('error', 'El libro no está disponible.');
        }

        $this->modelo->crear(
            $idLibro,
            $this->request->getPost('id_usuario'),
            $this->request->getPost('fecha_prestamo') ?: null,
            $this->request->getPost('fecha_devolucion') ?: null
        );

        $this->libroModel->update($idLibro, ['estado' => 'Prestado']);

        return redirect()->to(base_url('prestamos'))->with('mensaje', 'Préstamo registrado correctamente');
    }

        public function devolver($id)
    {
        $prestamo = $this->modelo->marcarDevueltoConRetraso($id);

        if (!$prestamo) {
            return redirect()->to(base_url('prestamos'))->with('error', 'No se encontró el préstamo.');
        }

        return redirect()->to(base_url('prestamos'))->with('mensaje', 'Préstamo devuelto correctamente');
    }


    public function vencidos()
    {
        $data['prestamos'] = $this->modelo->obtenerPrestamosActivos();
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

        if ($estado === 'Devuelto') {
            $this->libroModel->update($datos['id_libro'], ['estado' => 'Disponible']);
        }

        return redirect()->to(base_url('prestamos'))->with('mensaje', 'Préstamo actualizado correctamente');
    }
}

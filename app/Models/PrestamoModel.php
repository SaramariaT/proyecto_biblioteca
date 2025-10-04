<?php

namespace App\Models;

use CodeIgniter\Model;

class PrestamoModel extends Model
{
    protected $table = 'prestamos';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id_libro',
        'id_usuario',
        'fecha_prestamo',
        'fecha_devolucion',
        'estado',
        'fecha_real_devolucion',
        'retraso',
        'progreso'
    ];

    /**
     * Crear préstamo usando ID del libro
     */
    public function crear($id_libro, $id_usuario, $fecha_prestamo = null, $fecha_devolucion = null, $diasPrestamo = 7)
    {
        if (empty($fecha_prestamo)) {
            $fecha_prestamo = date('Y-m-d');
        }

        if (empty($fecha_devolucion)) {
            $fecha_devolucion = date('Y-m-d', strtotime("+{$diasPrestamo} days", strtotime($fecha_prestamo)));
        }

        return $this->insert([
            'id_libro'               => $id_libro,
            'id_usuario'             => $id_usuario,
            'fecha_prestamo'         => $fecha_prestamo,
            'fecha_devolucion'       => $fecha_devolucion,
            'estado'                 => 'Prestado',
            'progreso'               => 'en curso',
            'retraso'                => 0,
            'fecha_real_devolucion'  => null
        ]);
    }

    /**
     * Obtener todos los préstamos con JOIN a usuarios y libros
     */
    public function obtenerTodos()
    {
        return $this->db->table($this->table . ' p')
            ->select('p.*, u.nombre AS usuario, l.codigo AS codigo_libro, l.titulo AS libro')
            ->join('usuarios_biblioteca u', 'p.id_usuario = u.id')
            ->join('libros l', 'p.id_libro = l.id')
            ->orderBy('p.fecha_prestamo', 'DESC')
            ->get()
            ->getResultArray();
    }

    /**
     * Obtener préstamos activos
     */
    public function obtenerPrestamosActivos()
    {
        return $this->db->table($this->table . ' p')
            ->select('p.*, u.nombre AS usuario, l.codigo AS codigo_libro, l.titulo AS libro')
            ->join('usuarios_biblioteca u', 'p.id_usuario = u.id')
            ->join('libros l', 'p.id_libro = l.id')
            ->where('p.estado', 'Prestado')
            ->where('p.progreso', 'en curso')
            ->orderBy('p.fecha_prestamo', 'DESC')
            ->get()
            ->getResultArray();
    }

    /**
     * Marcar préstamo como devuelto
     */
    public function marcarDevueltoConRetraso($id)
    {
        $prestamo = $this->find($id);
        if (!$prestamo) {
            return null;
        }

        $hoy = date('Y-m-d');
        $retraso = ($hoy > $prestamo['fecha_devolucion']);

        $this->update($id, [
            'estado'                 => 'Devuelto',
            'fecha_real_devolucion'  => $hoy,
            'retraso'                => $retraso ? 1 : 0,
            'progreso'               => 'completado'
        ]);

        $prestamo['estado'] = 'Devuelto';
        $prestamo['fecha_real_devolucion'] = $hoy;
        $prestamo['retraso'] = $retraso ? 1 : 0;
        $prestamo['progreso'] = 'completado';

        return $prestamo;
    }

    /**
     * Obtener préstamos por código de libro
     */
    public function obtenerPorCodigoLibro($codigo)
    {
        return $this->db->table($this->table . ' p')
            ->select('p.*, u.nombre AS usuario, l.codigo AS codigo_libro, l.titulo AS libro')
            ->join('usuarios_biblioteca u', 'p.id_usuario = u.id')
            ->join('libros l', 'p.id_libro = l.id')
            ->where('l.codigo', $codigo)
            ->orderBy('p.fecha_prestamo', 'DESC')
            ->get()
            ->getResultArray();
    }
}

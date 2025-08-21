<?php

namespace App\Models;

use CodeIgniter\Model;

class PrestamoModel extends Model
{
    protected $table = 'prestamos_libros';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id_ejemplar',
        'id_usuario',
        'fecha_prestamo',
        'fecha_devolucion',
        'estado',
        'fecha_real_devolucion',
        'retraso',
        'progreso' // ← nuevo campo incluido
    ];

    // Crear préstamo
    public function crear($id_ejemplar, $id_usuario, $fecha_prestamo, $fecha_devolucion)
    {
        return $this->insert([
            'id_ejemplar' => $id_ejemplar,
            'id_usuario' => $id_usuario,
            'fecha_prestamo' => $fecha_prestamo,
            'fecha_devolucion' => $fecha_devolucion,
            'estado' => 'Prestado',
            'progreso' => 'en curso' // ← inicializado al crear
        ]);
    }

    // Obtener todos los préstamos con JOIN
    public function obtenerTodos()
    {
        return $this->db->table($this->table . ' p')
            ->select('p.*, u.nombre AS usuario, e.codigo_ejemplar AS ejemplar, l.titulo AS libro')
            ->join('usuarios_biblioteca u', 'p.id_usuario = u.id')
            ->join('ejemplares e', 'p.id_ejemplar = e.id')
            ->join('libros l', 'e.id_libro = l.id')
            ->get()
            ->getResultArray();
    }

    // Marcar como devuelto con control de retraso
    public function marcarDevueltoConRetraso($id)
    {
        $prestamo = $this->find($id);
        $hoy = date('Y-m-d');
        $retraso = $hoy > $prestamo['fecha_devolucion'];

        return $this->update($id, [
            'estado' => 'Devuelto',
            'fecha_real_devolucion' => $hoy,
            'retraso' => $retraso,
            'progreso' => 'completado' // ← actualizado al devolver
        ]);
    }
}

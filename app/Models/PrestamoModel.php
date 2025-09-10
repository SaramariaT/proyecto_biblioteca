<?php

namespace App\Models;

use CodeIgniter\Model;

class PrestamoModel extends Model
{
    protected $table = 'prestamos';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id_ejemplar',
        'id_usuario',
        'fecha_prestamo',
        'fecha_devolucion',
        'estado',
        'fecha_real_devolucion',
        'retraso',
        'progreso'
    ];

    /**
     * Crear préstamo
     * Si no se pasa fecha_devolucion, se calcula automáticamente sumando $diasPrestamo días
     */
    public function crear($id_ejemplar, $id_usuario, $fecha_prestamo = null, $fecha_devolucion = null, $diasPrestamo = 7)
    {
        // Fecha de préstamo por defecto: hoy
        if (empty($fecha_prestamo)) {
            $fecha_prestamo = date('Y-m-d');
        }

        // Fecha de devolución por defecto: fecha_prestamo + $diasPrestamo días
        if (empty($fecha_devolucion)) {
            $fecha_devolucion = date('Y-m-d', strtotime("+{$diasPrestamo} days", strtotime($fecha_prestamo)));
        }

        return $this->insert([
            'id_ejemplar'        => $id_ejemplar,
            'id_usuario'         => $id_usuario,
            'fecha_prestamo'     => $fecha_prestamo,
            'fecha_devolucion'   => $fecha_devolucion,
            'estado'             => 'Prestado',
            'progreso'           => 'en curso',
            'retraso'            => 0,
            'fecha_real_devolucion' => null
        ]);
    }

    /**
     * Obtener todos los préstamos con JOIN a usuarios, ejemplares y libros
     */
    public function obtenerTodos()
    {
        return $this->db->table($this->table . ' p')
            ->select('p.*, u.nombre AS usuario, e.codigo_ejemplar AS ejemplar, e.estado AS estado_ejemplar, l.titulo AS libro')
            ->join('usuarios_biblioteca u', 'p.id_usuario = u.id')
            ->join('ejemplares e', 'p.id_ejemplar = e.id')
            ->join('libros l', 'e.id_libro = l.id')
            ->orderBy('p.fecha_prestamo', 'DESC')
            ->get()
            ->getResultArray();
    }

    /**
     * Marcar préstamo como devuelto y calcular retraso automáticamente
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

        // Devolver datos actualizados
        $prestamo['estado'] = 'Devuelto';
        $prestamo['fecha_real_devolucion'] = $hoy;
        $prestamo['retraso'] = $retraso ? 1 : 0;
        $prestamo['progreso'] = 'completado';

        return $prestamo;
    }
}

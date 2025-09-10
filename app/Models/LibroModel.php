<?php

namespace App\Models;

use CodeIgniter\Model;

class LibroModel extends Model
{
    protected $table = 'libros';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'codigo', 'titulo', 'autor', 'genero',
        'paginas', 'numero_ejemplar', 'total_ejemplares', 'nivel'
    ];

    public function obtenerLibros()
    {
        return $this->findAll();
    }

    public function obtenerLibrosConEstadoYPrestamo()
    {
        return $this->db->table('libros l')
            ->select('
                l.codigo, l.titulo, l.autor, l.genero, l.paginas,
                l.numero_ejemplar, l.total_ejemplares, l.nivel,
                e.codigo_ejemplar, e.estado,
                ub.nombre AS nombre_usuario, p.fecha_prestamo, p.fecha_devolucion
            ')
            ->join('ejemplares e', 'e.id_libro = l.id')
            ->join('prestamos_libros p', 'p.id_ejemplar = e.id AND p.estado = "Prestado"', 'left')
            ->join('usuarios_biblioteca ub', 'ub.id = p.id_usuario', 'left')
            ->get()->getResultArray();
    }
}

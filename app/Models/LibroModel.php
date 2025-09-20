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
                ub.nombre AS nombre_usuario,
                p.fecha_prestamo, p.fecha_devolucion,
                CASE 
                    WHEN p.fecha_devolucion < CURDATE() AND p.estado = "Prestado" THEN 1
                    ELSE 0
                END AS retraso
            ')
            ->join('ejemplares e', 'e.id_libro = l.id')
            ->join('prestamos p', 'p.id_ejemplar = e.id AND p.estado = "Prestado"', 'left')
            ->join('usuarios_biblioteca ub', 'ub.id = p.id_usuario', 'left')
            ->orderBy('e.codigo_ejemplar', 'ASC')
            ->get()->getResultArray();
    }

    public function buscarLibros($busqueda = null)
    {
        $builder = $this->db->table('libros');

        if (!empty($busqueda)) {
            $builder->groupStart()
                    ->like('titulo', $busqueda)
                    ->orLike('autor', $busqueda)
                    ->orLike('genero', $busqueda)
                    ->groupEnd();
        }

        return $builder->get()->getResultArray();
    }
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class LibroModel extends Model
{
    protected $table = 'libros';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'codigo', 'titulo', 'autor', 'genero',
        'paginas', 'numero_ejemplar', 'total_ejemplares',
        'nivel', 'estado'
    ];

    // Obtener todos los libros
    public function obtenerLibros()
    {
        return $this->findAll();
    }

    // Obtener libros con su estado actual (incluye ID para usar en vistas)
    public function obtenerLibrosConEstado()
    {
        return $this->db->table('libros')
            ->select('id, codigo, titulo, autor, genero, paginas, numero_ejemplar, total_ejemplares, nivel, estado')
            ->orderBy('codigo', 'ASC')
            ->get()->getResultArray();
    }

    // Obtener libros con estado y datos de préstamo (sin tabla ejemplares)
    public function obtenerLibrosConEstadoYPrestamo()
    {
        return $this->db->table('libros')
            ->select('
                libros.id,
                libros.codigo,
                libros.titulo,
                libros.autor,
                libros.genero,
                libros.paginas,
                libros.numero_ejemplar,
                libros.total_ejemplares,
                libros.nivel,
                libros.estado,
                libros.codigo AS codigo_ejemplar,
                prestamos.fecha_prestamo,
                prestamos.fecha_devolucion,
                prestamos.retraso,
                usuarios_biblioteca.nombre AS nombre_usuario
            ')
            ->join('prestamos', 'prestamos.id_libro = libros.id AND prestamos.estado = "Prestado"', 'left')
            ->join('usuarios_biblioteca', 'usuarios_biblioteca.id = prestamos.id_usuario', 'left')
            ->orderBy('libros.codigo', 'ASC')
            ->get()->getResultArray();
    }


    // Buscar libros por título, autor o género
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

    // Actualizar el estado del libro (Prestado / Disponible)
    public function actualizarEstado($idLibro, $nuevoEstado)
    {
        return $this->update($idLibro, ['estado' => $nuevoEstado]);
    }
}

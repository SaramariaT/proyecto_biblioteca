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

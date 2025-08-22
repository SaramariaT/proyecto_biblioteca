<?php

namespace App\Models;

use CodeIgniter\Model;

class LibroModel extends Model
{
    protected $table = 'libros';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id_categoria', 'titulo', 'autor', 'editorial',
        'anio_publicacion', 'precio_venta', 'stock'
    ];

    public function obtenerLibrosConCategoria()
    {
        return $this->select('libros.*, categorias.nom_categoria')
                    ->join('categorias', 'categorias.id = libros.id_categoria')
                    ->findAll();
    }

public function obtenerLibrosConEstadoYPrestamo()
{
    return $this->db->table('libros l')
        ->select('
            l.titulo, l.autor, l.editorial, l.anio_publicacion, l.stock, c.nom_categoria,
            e.codigo_ejemplar, e.estado,
            ub.nombre AS nombre_usuario, p.fecha_prestamo, p.fecha_devolucion
        ')
        ->join('categorias c', 'c.id = l.id_categoria')
        ->join('ejemplares e', 'e.id_libro = l.id')
        ->join('prestamos_libros p', 'p.id_ejemplar = e.id AND p.estado = "Prestado"', 'left')
        ->join('usuarios_biblioteca ub', 'ub.id = p.id_usuario', 'left')
        ->get()->getResultArray();
}



}

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
}

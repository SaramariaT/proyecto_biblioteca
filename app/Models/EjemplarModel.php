<?php

namespace App\Models;

use CodeIgniter\Model;

class EjemplarModel extends Model
{
    protected $table = 'ejemplares';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_libro', 'codigo_ejemplar', 'estado'];
}

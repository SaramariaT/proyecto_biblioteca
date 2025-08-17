<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioBibliotecaModel extends Model
{
    protected $table            = 'usuarios_biblioteca';
    protected $primaryKey       = 'id';
    protected $allowedFields = ['nombre', 'carne', 'correo', 'rol'];  // ajusta según tus columnas
    protected $useTimestamps    = true;
}

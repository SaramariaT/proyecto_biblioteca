<?php

namespace App\Controllers;

use App\Models\UsuarioBibliotecaModel;

class Panel extends BaseController
{
    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/');
        }

        $carne = session()->get('usuario');
        $perfilModel = new UsuarioBibliotecaModel();
        $perfil = $perfilModel->where('carne', $carne)->first();

        if ($perfil && !empty($perfil['nombre'])) {
            session()->set('nombre_usuario', $perfil['nombre']);
        } else {
            session()->set('nombre_usuario', 'Usuario');
        }

        return view('panel/index');
    }
}

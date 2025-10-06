<?php
namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\UsuarioBibliotecaModel;

class Login extends BaseController
{
    public function index()
    {
        return view('login');
    }
    
    public function autenticar()
    {
        $usuario = $this->request->getPost('usuario');
        $password = $this->request->getPost('password');
        
        $usuarioModel = new UsuarioModel();
        $datosUsuario = $usuarioModel->verificarUsuario($usuario, $password);
        
        if ($datosUsuario) {
            session()->set([
                'usuario' => $datosUsuario['usuario'],
                'logged_in' => true
            ]);
            return redirect()->to('/panel');
        } else {
            return redirect()->back()->with('error', 'Usuario o contraseña incorrectos');
        }
    }
    
public function panel()
{
    if (!session()->get('logged_in')) {
        return redirect()->to('/');
    }

    $carne = session()->get('usuario'); // carne del usuario
    $perfilModel = new \App\Models\UsuarioBibliotecaModel();
    $perfil = $perfilModel->where('carne', $carne)->first();

    if ($perfil && !empty($perfil['nombre'])) {
        session()->set('nombre_usuario', $perfil['nombre']); // ✅ Guardar nombre en sesión
    } else {
        session()->set('nombre_usuario', 'Usuario');
    }

    return view('panel/index');
}


    
    public function salir()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}

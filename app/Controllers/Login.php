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
            // Buscar perfil en usuarios_biblioteca
            $perfilModel = new UsuarioBibliotecaModel();
            $perfil = $perfilModel->where('carne', $usuario)->first();

            // Guardar datos en sesión
            session()->set([
                'usuario' => $usuario,
                'logged_in' => true,
                'nombre_usuario' => $perfil['nombre'] ?? 'Usuario',
                'rol_usuario' => isset($perfil['rol']) ? ucfirst(trim(strtolower($perfil['rol']))) : 'Invitado'
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
            session()->set('nombre_usuario', $perfil['nombre']); // Guardar nombre en sesión
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

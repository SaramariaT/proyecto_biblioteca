<?php

namespace App\Controllers;

use App\Models\UsuarioBibliotecaModel;

class UsuariosBiblioteca extends BaseController
{
    public function index()
    {
        $model = new UsuarioBibliotecaModel();
        $data['usuarios'] = $model->findAll();
        return view('usuarios_biblioteca/index', $data);
    }

    public function create()
    {
        return view('usuarios_biblioteca/create');
    }

    public function store()
    {
        $model = new UsuarioBibliotecaModel();
        $datos = $this->request->getPost();

        // Guardar en usuarios_biblioteca
        $model->save($datos);

        // Crear usuario de acceso con contraseña MD5
        $db = \Config\Database::connect();
        $usuario = $datos['carne']; // o el campo que uses como login
        $password = md5('12345'); // encriptado con MD5

        $db->table('usuarios')->insert([
            'usuario' => $usuario,
            'password' => $password
        ]);

        return redirect()->to('/usuarios-biblioteca')->with('mensaje', 'Usuario creado correctamente con acceso a la plataforma');
    }

    public function edit($id)
    {
        $model = new UsuarioBibliotecaModel();
        $data['usuario'] = $model->find($id);
        return view('usuarios_biblioteca/edit', $data);
    }

    public function update($id)
    {
        $model = new UsuarioBibliotecaModel();
        $datos = $this->request->getPost();

        // Actualizar datos del usuario
        $model->update($id, $datos);

        $mensaje = 'Usuario actualizado correctamente';

        // Si se ingresó una nueva contraseña, actualizarla en la tabla de acceso
        if (!empty($datos['reset_password'])) {
            $db = \Config\Database::connect();
            $usuario = $datos['carne'];
            $nuevaPassword = md5($datos['reset_password']);

            $db->table('usuarios')
                ->where('usuario', $usuario)
                ->update(['password' => $nuevaPassword]);

            $mensaje .= ' y contraseña restablecida';
        }

        return redirect()->to('/usuarios-biblioteca')->with('mensaje', $mensaje);
    }

    public function delete($id)
    {
        $model = new UsuarioBibliotecaModel();
        $model->delete($id);
        return redirect()->to('/usuarios-biblioteca')->with('mensaje', 'Usuario eliminado');
    }
}

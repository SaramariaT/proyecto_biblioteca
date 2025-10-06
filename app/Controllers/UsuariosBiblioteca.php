<?php

namespace App\Controllers;

use App\Models\UsuarioBibliotecaModel;

class UsuariosBiblioteca extends BaseController
{
    public function index()
    {
        $model = new UsuarioBibliotecaModel();
        $busqueda = $this->request->getGet('busqueda');

        if (!empty($busqueda)) {
            $data['usuarios'] = $model
                ->like('nombre', $busqueda)
                ->orLike('carne', $busqueda)
                ->orLike('correo', $busqueda)
                ->orLike('rol', $busqueda)
                ->findAll();
        } else {
            $data['usuarios'] = $model->findAll();
        }

        $data['busqueda'] = $busqueda;
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
        $usuario = $datos['carne'];
        $password = md5('12345');

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

        $model->update($id, $datos);
        $mensaje = 'Usuario actualizado correctamente';

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
        $perfilModel = new UsuarioBibliotecaModel();
        $db = \Config\Database::connect();

        // Obtener el perfil antes de eliminar
        $perfil = $perfilModel->find($id);

        if ($perfil) {
            $carne = $perfil['carne'];

            // Eliminar de usuarios_biblioteca
            $perfilModel->delete($id);

            // Eliminar de usuarios (login)
            $db->table('usuarios')->where('usuario', $carne)->delete();

            return redirect()->to('/usuarios-biblioteca')->with('mensaje', 'Usuario eliminado correctamente');
        }

        return redirect()->to('/usuarios-biblioteca')->with('mensaje', 'Usuario no encontrado');
    }
}

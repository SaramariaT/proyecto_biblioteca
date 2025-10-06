<?php

namespace App\Controllers;

use App\Models\UsuarioBibliotecaModel;

class UsuariosBiblioteca extends BaseController
{
    public function index()
    {
        if (!tienePermiso('ver', 'usuarios')) {
            return redirect()->to('/panel')->with('error', 'No tienes permiso para ver usuarios.');
        }

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
        if (!tienePermiso('crear', 'usuarios')) {
            return redirect()->to('/usuarios-biblioteca')->with('error', 'No tienes permiso para agregar usuarios.');
        }

        return view('usuarios_biblioteca/create');
    }

    public function store()
    {
        if (!tienePermiso('crear', 'usuarios')) {
            return redirect()->to('/usuarios-biblioteca')->with('error', 'No tienes permiso para guardar usuarios.');
        }

        $model = new UsuarioBibliotecaModel();
        $datos = $this->request->getPost();

        $model->save($datos);

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
        if (!tienePermiso('editar', 'usuarios')) {
            return redirect()->to('/usuarios-biblioteca')->with('error', 'No tienes permiso para editar usuarios.');
        }

        $model = new UsuarioBibliotecaModel();
        $data['usuario'] = $model->find($id);
        return view('usuarios_biblioteca/edit', $data);
    }

    public function update($id)
    {
        if (!tienePermiso('editar', 'usuarios')) {
            return redirect()->to('/usuarios-biblioteca')->with('error', 'No tienes permiso para actualizar usuarios.');
        }

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
        if (!tienePermiso('eliminar', 'usuarios')) {
            return redirect()->to('/usuarios-biblioteca')->with('error', 'No tienes permiso para eliminar usuarios.');
        }

        $perfilModel = new UsuarioBibliotecaModel();
        $db = \Config\Database::connect();

        $perfil = $perfilModel->find($id);

        if ($perfil) {
            $carne = $perfil['carne'];

            $perfilModel->delete($id);
            $db->table('usuarios')->where('usuario', $carne)->delete();

            return redirect()->to('/usuarios-biblioteca')->with('mensaje', 'Usuario eliminado correctamente');
        }

        return redirect()->to('/usuarios-biblioteca')->with('mensaje', 'Usuario no encontrado');
    }
}

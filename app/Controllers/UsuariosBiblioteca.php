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
        $model->save($this->request->getPost());
        return redirect()->to('/usuarios-biblioteca')->with('mensaje', 'Usuario creado correctamente');
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
        $model->update($id, $this->request->getPost());
        return redirect()->to('/usuarios-biblioteca')->with('mensaje', 'Usuario actualizado');
    }

    public function delete($id)
    {
        $model = new UsuarioBibliotecaModel();
        $model->delete($id);
        return redirect()->to('/usuarios-biblioteca')->with('mensaje', 'Usuario eliminado');
    }
}

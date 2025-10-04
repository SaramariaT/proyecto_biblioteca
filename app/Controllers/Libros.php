<?php

namespace App\Controllers;

use App\Models\LibroModel;

class Libros extends BaseController
{
    public function index()
    {
        $model = new LibroModel();
        $busqueda = $this->request->getGet('busqueda');

        if (!empty($busqueda)) {
            $data['libros'] = $model->buscarLibros($busqueda);
        } else {
            $data['libros'] = $model->obtenerLibrosConEstado();
        }

        $data['busqueda'] = $busqueda;
        return view('libros/index', $data);
    }

    public function create()
    {
        return view('libros/create');
    }

    public function store()
    {
        $datos = $this->request->getPost();

        $model = new LibroModel();
        $model->save($datos);

        return redirect()->to('/libros');
    }

    public function edit($id)
    {
        $model = new LibroModel();
        $data['libro'] = $model->find($id);
        return view('libros/edit', $data);
    }

    public function update($id)
    {
        $model = new LibroModel();
        $model->update($id, $this->request->getPost());
        return redirect()->to('/libros');
    }

    public function delete($id)
    {
        $model = new LibroModel();
        $model->delete($id);
        return redirect()->to('/libros');
    }

    public function cambiarEstado($id, $estado)
    {
        $model = new LibroModel();
        $model->actualizarEstado($id, $estado);
        return redirect()->to('/libros');
    }
}

<?php

namespace App\Controllers;

use App\Models\LibroModel;
use App\Models\CategoriaModel;

class Libros extends BaseController
{
    public function index()
    {
        $model = new LibroModel();
        $data['libros'] = $model
    ->select('libros.*, categorias.nom_categoria')
    ->join('categorias', 'categorias.id = libros.id_categoria')
    ->findAll();

        return view('libros/index', $data);
    }

    public function create()
    {
        $catModel = new CategoriaModel();
        $data['categorias'] = $catModel->findAll();
        return view('libros/create', $data);
    }

    public function store()
    {
        $model = new LibroModel();
        $model->save($this->request->getPost());
        return redirect()->to('/libros');
    }

    public function edit($id)
    {
        $model = new LibroModel();
        $catModel = new CategoriaModel();
        $data['libro'] = $model->find($id);
        $data['categorias'] = $catModel->findAll();
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
}

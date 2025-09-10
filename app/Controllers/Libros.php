<?php

namespace App\Controllers;

use App\Models\LibroModel;

class Libros extends BaseController
{
    public function index()
    {
        $model = new LibroModel();
        $data['libros'] = $model->findAll();
        return view('libros/index', $data);
    }

    public function create()
    {
        return view('libros/create');
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
}

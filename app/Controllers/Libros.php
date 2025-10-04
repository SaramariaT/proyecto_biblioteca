<?php

namespace App\Controllers;

use App\Models\LibroModel;
use App\Models\PrestamoModel;

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
        $data['mensaje'] = session()->getFlashdata('mensaje');
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

        session()->setFlashdata('mensaje', '📚 Libro creado exitosamente.');
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

        session()->setFlashdata('mensaje', '✅ Libro actualizado correctamente.');
        return redirect()->to('/libros');
    }

    public function delete($id)
    {
        $libroModel = new LibroModel();
        $prestamoModel = new PrestamoModel();

        // Eliminar préstamos asociados al libro
        $prestamoModel->where('id_libro', $id)->delete();

        // Eliminar el libro
        $libroModel->delete($id);

        session()->setFlashdata('mensaje', '🗑️ Libro y préstamos eliminados correctamente.');
        return redirect()->to('/libros');
    }

    public function cambiarEstado($id, $estado)
    {
        $model = new LibroModel();
        $model->actualizarEstado($id, $estado);

        session()->setFlashdata('mensaje', '📌 Estado del libro actualizado.');
        return redirect()->to('/libros');
    }
}

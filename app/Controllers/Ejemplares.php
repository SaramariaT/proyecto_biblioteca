<?php

namespace App\Controllers;

use App\Models\EjemplarModel;
use App\Models\LibroModel;

class Ejemplares extends BaseController
{
    public function index()
    {
        $model = new EjemplarModel();
        $data['ejemplares'] = $model
            ->select('ejemplares.*, libros.titulo, libros.codigo')
            ->join('libros', 'libros.id = ejemplares.id_libro')
            ->findAll();

        return view('ejemplares/index', $data);
    }

    public function create($id_libro)
    {
        $libroModel = new LibroModel();
        $libro = $libroModel->find($id_libro);

        $data['id_libro'] = $id_libro;
        $data['libro'] = $libro;

        return view('ejemplares/create', $data);
    }

    public function store()
    {
        $model = new EjemplarModel();
        $libroModel = new LibroModel();

        $id_libro = $this->request->getPost('id_libro');
        $estado = $this->request->getPost('estado');

        // Calcular número de ejemplar
        $count = $model->where('id_libro', $id_libro)->countAllResults();
        $numero = str_pad($count + 1, 2, '0', STR_PAD_LEFT);
        $codigo = 'LIB' . str_pad($id_libro, 3, '0', STR_PAD_LEFT) . '-' . $numero;

        // Guardar ejemplar
        $model->save([
            'id_libro' => $id_libro,
            'codigo_ejemplar' => $codigo,
            'estado' => $estado
        ]);

        // Incrementar total de ejemplares en la tabla libros
        $libroModel->set('total_ejemplares', 'total_ejemplares + 1', false)
                   ->where('id', $id_libro)
                   ->update();

        return redirect()->to('/ejemplares/ver/' . $id_libro)
                         ->with('mensaje', 'Ejemplar creado correctamente');
    }

    public function ver($idLibro)
    {
        $ejemplarModel = new EjemplarModel();
        $libroModel = new LibroModel();

        $libro = $libroModel->find($idLibro);
        $ejemplares = $ejemplarModel->where('id_libro', $idLibro)->findAll();

        return view('ejemplares/index', [
            'libro' => $libro,
            'ejemplares' => $ejemplares
        ]);
    }

    public function delete($id)
    {
        $model = new EjemplarModel();
        $libroModel = new LibroModel();

        $ejemplar = $model->find($id);
        $id_libro = $ejemplar['id_libro'];

        // Eliminar ejemplar
        $model->delete($id);

        // Decrementar total de ejemplares en la tabla libros
        $libroModel->set('total_ejemplares', 'total_ejemplares - 1', false)
                ->where('id', $id_libro)
                ->update();

        // Redirigir al método ver() para que cargue $libro y $ejemplares
        return redirect()->to('/ejemplares/ver/' . $id_libro)
                        ->with('mensaje', 'Ejemplar eliminado correctamente');
    }

}

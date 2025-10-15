<?php

namespace App\Controllers;

use App\Models\LibroModel;
use App\Models\CategoriaModel;

class LibroController extends BaseController
{
    protected $libroModel;
    protected $categoriaModel;

    public function __construct()
    {
        $this->libroModel = new LibroModel();
        $this->categoriaModel = new CategoriaModel();
    }

    public function index()
    {
        //$data['libros'] = $this->libroModel->conCategoria();
        return view('libros/librosListado');
    }

    public function create()
    {
        $data['categorias'] = $this->categoriaModel->findAll();
        return view('libros/create', $data);
    }

    public function store()
    {
        $this->libroModel->insert([
            'titulo' => $this->request->getPost('titulo'),
            'autor' => $this->request->getPost('autor'),
            'editorial' => $this->request->getPost('editorial'),
            'anio' => $this->request->getPost('anio'),
            'disponibilidad' => 1,
            'id_categoria' => $this->request->getPost('id_categoria'),
        ]);
        return redirect()->to('/libros');
    }

    public function delete($id)
    {
        $this->libroModel->delete($id);
        return redirect()->to('/libros');
    }
}

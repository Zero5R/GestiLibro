<?php

namespace App\Controllers;

use App\Models\CategoriaModel;

class CategoriaController extends BaseController
{
    protected $categoriaModel;

    public function __construct()
    {
        $this->categoriaModel = new CategoriaModel();
    }

    public function index()
    {
        $data['categorias'] = $this->categoriaModel->findAll();
        return view('categorias/index', $data);
    }

    public function create()
    {
        return view('categorias/create');
    }

    public function store()
    {
        $this->categoriaModel->insert([
            'nombre' => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion')
        ]);
        return redirect()->to('/categorias');
    }

    public function delete($id)
    {
        $this->categoriaModel->delete($id);
        return redirect()->to('/categorias');
    }
}

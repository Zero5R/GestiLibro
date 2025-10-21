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
        $data['libros'] = $this->libroModel->conCategoria();
        return view('libros/index', $data);
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
            'disponibilidad' => $this->request->getPost('disponibilidad') ?? 1,
            'id_categoria' => $this->request->getPost('id_categoria'),
        ]);
        return redirect()->to('/libros');
    }

    public function edit($id)
    {
        $data['libro'] = $this->libroModel->find($id);
        $data['categorias'] = $this->categoriaModel->findAll();
        return view('libros/edit', $data);
    }

    public function update($id)
    {
        $this->libroModel->update($id, [
            'titulo' => $this->request->getPost('titulo'),
            'autor' => $this->request->getPost('autor'),
            'editorial' => $this->request->getPost('editorial'),
            'anio' => $this->request->getPost('anio'),
            'disponibilidad' => $this->request->getPost('disponibilidad'),
            'id_categoria' => $this->request->getPost('id_categoria'),
        ]);

        return redirect()->to(site_url('libros'));
    }

    public function delete($id)
    {
        try {
            $libro = $this->libroModel->getLibroConEstado($id);

            if (!$libro) {
                return redirect()->to('/libros')->with('error', 'Libro no encontrado.');
            }
            $libro->eliminar();

            return redirect()->to('/libros')->with('success', 'Libro marcado como no disponible.');
        } catch (\Exception $e) {
            return redirect()->to('/libros')->with('error', $e->getMessage());
        }
    }

}

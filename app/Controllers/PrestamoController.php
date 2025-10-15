<?php

namespace App\Controllers;

use App\Models\PrestamoModel;
use App\Models\UsuarioModel;
use App\Models\LibroModel;

class PrestamoController extends BaseController
{
    protected $prestamoModel;
    protected $usuarioModel;
    protected $libroModel;

    public function __construct()
    {
        $this->prestamoModel = new PrestamoModel();
        $this->usuarioModel = new UsuarioModel();
        $this->libroModel = new LibroModel();
    }

    public function index()
    {
        $data['prestamos'] = $this->prestamoModel->conDetalles();
        return view('prestamos/index', $data);
    }

    public function create()
    {
        $data['usuarios'] = $this->usuarioModel->findAll();
        $data['libros'] = $this->libroModel->findAll();
        return view('prestamos/create', $data);
    }

    public function store()
    {
        $this->prestamoModel->insert([
            'id_usuario' => $this->request->getPost('id_usuario'),
            'id_libro' => $this->request->getPost('id_libro'),
            'fecha_prestamo' => date('Y-m-d'),
            'estado' => 'prestado'
        ]);
        return redirect()->to('/prestamos');
    }

    public function delete($id)
    {
        $this->prestamoModel->delete($id);
        return redirect()->to('/prestamos');
    }
}

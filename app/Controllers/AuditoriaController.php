<?php

namespace App\Controllers;

use App\Models\AuditoriaModel;
use App\Models\UsuarioModel;
use App\Models\LibroModel;

class AuditoriaController extends BaseController
{
    protected $auditoriaModel;
    protected $usuarioModel;
    protected $libroModel;

    public function __construct()
    {
        $this->auditoriaModel = new AuditoriaModel();
        $this->usuarioModel = new UsuarioModel();
        $this->libroModel = new LibroModel();
    }

    public function index()
    {
        $data['auditorias'] = $this->auditoriaModel->conDetalles();
        return view('auditorias/index', $data);
    }

    public function create()
    {
        $data['usuarios'] = $this->usuarioModel->findAll();
        $data['libros'] = $this->libroModel->findAll();
        return view('auditorias/create', $data);
    }

    public function store()
    {
        $this->auditoriaModel->insert([
            'id_usuario' => $this->request->getPost('id_usuario'),
            'id_libro' => $this->request->getPost('id_libro'),
            'accion' => $this->request->getPost('accion'),
            'descripcion' => $this->request->getPost('descripcion'),
            'estado' => $this->request->getPost('estado'),
            'fecha' => date('Y-m-d'),
        ]);
        return redirect()->to('/auditorias');
    }

    public function delete($id)
    {
        $this->auditoriaModel->delete($id);
        return redirect()->to('/auditorias');
    }
}

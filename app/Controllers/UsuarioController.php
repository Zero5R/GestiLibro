<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\RolModel;

class UsuarioController extends BaseController
{
    protected $usuarioModel;
    protected $rolModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
        $this->rolModel = new RolModel();
    }

    public function index()
    {
        $data['usuarios'] = $this->usuarioModel->obtenerRol();
        return view('usuarios/index', $data);
    }

    public function create()
    {
        $data['roles'] = $this->rolModel->findAll();
        return view('usuarios/create', $data);
    }

    public function store()
    {
        $this->usuarioModel->insert([
            'nombre' => $this->request->getPost('nombre'),
            'apellido' => $this->request->getPost('apellido'),
            'correo' => $this->request->getPost('correo'),
            'contrasena' => password_hash($this->request->getPost('contrasena'), PASSWORD_DEFAULT),
            'id_rol' => $this->request->getPost('id_rol'),
        ]);
        return redirect()->to('/usuarios');
    }

    public function delete($id)
    {
        $this->usuarioModel->delete($id);
        return redirect()->to('/usuarios');
    }
}

<?php

namespace App\Controllers;

use App\Models\RolModel;
use App\Models\UsuarioModel;

class RolController extends BaseController
{
    protected $rolModel;
    protected $usuarioModel;

    public function __construct()
    {
        $this->rolModel = new RolModel();
        $this->usuarioModel = new UsuarioModel();
    }

    public function index()
    {
        $data['roles'] = $this->rolModel->findAll();
        return view('roles/index', $data);
    }

    public function create()
    {
        return view('roles/create', [
            'validation' => \Config\Services::validation()
        ]);
    }

    public function store()
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'nombre' => [
                'rules' => 'required|in_list[administrador,usuario]|is_unique[Rol.nombre]',
                'errors' => [
                    'required' => 'El nombre del rol es obligatorio.',
                    'in_list' => 'Solo se permite crear "administrador" o "usuario" (en minúsculas).',
                    'is_unique' => 'Este rol ya existe.'
                ]
            ]
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return view('roles/create', ['validation' => $validation]);
        }

        $this->rolModel->insert([
            'nombre' => $this->request->getPost('nombre')
        ]);

        return redirect()->to('/roles')->with('success', 'Rol creado correctamente.');
    }

    public function edit($id)
    {
        $rol = $this->rolModel->find($id);

        if (!$rol) {
            return redirect()->to('/roles')->with('error', 'Rol no encontrado.');
        }

        return view('roles/edit', [
            'rol' => $rol,
            'validation' => \Config\Services::validation()
        ]);
    }

    public function update($id)
    {
        $rol = $this->rolModel->find($id);

        if (!$rol) {
            return redirect()->to('/roles')->with('error', 'Rol no encontrado.');
        }

        $validation = \Config\Services::validation();

        $validation->setRules([
            'nombre' => [
                'rules' => "required|in_list[administrador,usuario]|is_unique[Rol.nombre,id_rol,{$id}]",
                'errors' => [
                    'required' => 'El nombre del rol es obligatorio.',
                    'in_list' => 'Solo se permite "administrador" o "usuario" (en minúsculas).',
                    'is_unique' => 'Este rol ya existe.'
                ]
            ]
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return view('roles/edit', [
                'rol' => $rol,
                'validation' => $validation
            ]);
        }

        $this->rolModel->update($id, [
            'nombre' => $this->request->getPost('nombre')
        ]);

        return redirect()->to('/roles')->with('success', 'Rol actualizado correctamente.');
    }

    public function delete($id)
    {
        $rol = $this->rolModel->find($id);

        if (!$rol) {
            return redirect()->to('/roles')->with('error', 'Rol no encontrado.');
        }

        // Validación de negocio: no eliminar rol administrador
        if ($rol['nombre'] === 'administrador') {
            return redirect()->to('/roles')->with('error', 'No se puede eliminar el rol administrador.');
        }

        // Validación de negocio: si hay usuarios asociados, no permitir eliminar
        $usuariosAsociados = $this->usuarioModel
            ->where('id_rol', $id)
            ->countAllResults();

        if ($usuariosAsociados > 0) {
            return redirect()->to('/roles')->with('error', 'No se puede eliminar el rol porque hay usuarios asociados.');
        }

        $this->rolModel->delete($id);

        return redirect()->to('/roles')->with('success', 'Rol eliminado correctamente.');
    }
}

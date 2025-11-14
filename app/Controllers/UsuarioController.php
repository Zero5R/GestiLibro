<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\RolModel;
use App\Models\TareaModel;

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
        return view('usuarios/create', [
            'roles' => $this->rolModel->findAll(),
            'validation' => \Config\Services::validation()
        ]);
    }

    public function store()
    {
        $rules = [
            'nombre' => [
                'rules' => 'required|min_length[2]|alpha_space',
                'errors' => [
                    'required' => 'El nombre es obligatorio.',
                    'min_length' => 'El nombre debe tener al menos 2 caracteres.',
                    'alpha_space' => 'El nombre solo puede contener letras.',
                ]
            ],
            'apellido' => [
                'rules' => 'required|min_length[2]|alpha_space',
                'errors' => [
                    'required' => 'El apellido es obligatorio.',
                    'min_length' => 'El apellido debe tener al menos 2 caracteres.',
                    'alpha_space' => 'El apellido solo puede contener letras.',
                ]
            ],
            'correo' => [
                'rules' => 'required|valid_email|is_unique[Usuario.correo]',
                'errors' => [
                    'required' => 'El correo es obligatorio.',
                    'valid_email' => 'Debe ingresar un correo válido.',
                    'is_unique' => 'El correo ya está registrado.',
                ]
            ],
            'username' => [
                'rules' => 'required|min_length[4]|is_unique[Usuario.username]',
                'errors' => [
                    'required' => 'El nombre de usuario es obligatorio.',
                    'min_length' => 'El nombre de usuario debe tener mínimo 4 caracteres.',
                    'is_unique' => 'Este nombre de usuario ya existe.',
                ]
            ],
            'contrasena' => [
                'rules' => 'required|min_length[6]',
                'errors' => [
                    'required' => 'La contraseña es obligatoria.',
                    'min_length' => 'La contraseña debe tener al menos 6 caracteres.',
                ]
            ],
            'id_rol' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Debe seleccionar un rol.',
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $this->usuarioModel->insert([
            'nombre' => $this->request->getPost('nombre'),
            'apellido' => $this->request->getPost('apellido'),
            'correo' => $this->request->getPost('correo'),
            'username' => $this->request->getPost('username'),
            'contrasena' => password_hash($this->request->getPost('contrasena'), PASSWORD_DEFAULT),
            'id_rol' => $this->request->getPost('id_rol'),
        ]);

        return redirect()->to('/usuarios')->with('success', 'Usuario registrado correctamente.');
    }

    public function edit($id)
    {
        return view('usuarios/edit', [
            'usuario' => $this->usuarioModel->find($id),
            'roles' => $this->rolModel->findAll(),
            'validation' => \Config\Services::validation()
        ]);
    }

    public function update($id)
    {
        $usuario = $this->usuarioModel->find($id);

        if (!$usuario) {
            return redirect()->to('/usuarios')->with('error', 'El usuario no existe.');
        }

        $correoRegla = ($usuario['correo'] === $this->request->getPost('correo'))
            ? 'required|valid_email'
            : 'required|valid_email|is_unique[Usuario.correo]';

        $usernameRegla = ($usuario['username'] === $this->request->getPost('username'))
            ? 'required|min_length[4]'
            : 'required|min_length[4]|is_unique[Usuario.username]';

        $rules = [
            'nombre' => [
                'rules' => 'required|min_length[2]|alpha_space',
                'errors' => [
                    'required' => 'El nombre es obligatorio.',
                    'min_length' => 'El nombre debe tener al menos 2 caracteres.',
                ]
            ],
            'apellido' => [
                'rules' => 'required|min_length[2]|alpha_space',
                'errors' => [
                    'required' => 'El apellido es obligatorio.',
                    'min_length' => 'El apellido debe tener al menos 2 caracteres.',
                ]
            ],
            'correo' => [
                'rules' => $correoRegla,
                'errors' => [
                    'required' => 'El correo es obligatorio.',
                    'valid_email' => 'Debe ingresar un correo válido.',
                    'is_unique' => 'Este correo ya está registrado.',
                ]
            ],
            'username' => [
                'rules' => $usernameRegla,
                'errors' => [
                    'required' => 'El nombre de usuario es obligatorio.',
                    'min_length' => 'Debe tener mínimo 4 caracteres.',
                    'is_unique' => 'Este nombre de usuario ya existe.',
                ]
            ],
            'id_rol' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Debe seleccionar un rol.',
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'apellido' => $this->request->getPost('apellido'),
            'correo' => $this->request->getPost('correo'),
            'username' => $this->request->getPost('username'),
            'id_rol' => $this->request->getPost('id_rol'),
        ];

        if (!empty($this->request->getPost('contrasena'))) {
            $data['contrasena'] = password_hash($this->request->getPost('contrasena'), PASSWORD_DEFAULT);
        }

        $this->usuarioModel->update($id, $data);

        return redirect()->to('/usuarios')->with('success', 'Usuario actualizado correctamente.');
    }

    public function delete($id)
    {
        $usuario = $this->usuarioModel->find($id);

        if (!$usuario) {
            return redirect()->back()->with('error', 'El usuario no existe.');
        }

        // Validar tareas activas
        $tareasModel = new TareaModel();

        $tareasActivas = $tareasModel
            ->where('id_usuario', $id)
            ->whereIn('estado', ['pendiente', 'en_progreso'])
            ->countAllResults();

        if ($tareasActivas > 0) {
            return redirect()->back()->with(
                'error',
                'No puedes eliminar este usuario porque tiene tareas pendientes o en progreso.'
            );
        }

        $this->usuarioModel->delete($id);

        return redirect()->to('/usuarios')->with('success', 'Usuario eliminado correctamente.');
    }
}

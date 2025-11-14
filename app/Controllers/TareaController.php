<?php

namespace App\Controllers;

use App\Models\TareaModel;
use App\Models\UsuarioModel;

class TareaController extends BaseController
{
    protected $tareaModel;
    protected $usuarioModel;

    public function __construct()
    {
        $this->tareaModel = new TareaModel();
        $this->usuarioModel = new UsuarioModel();
    }

    public function index()
    {
        $data['tareas'] = $this->tareaModel->conUsuario();
        return view('tareas/index', $data);
    }

    public function create()
    {
        $data['usuarios'] = $this->usuarioModel->findAll();
        return view('tareas/create', $data);
    }

    public function store()
    {
    
        $rules = [
            'id_usuario' => 'required|integer',
            'titulo' => 'required|min_length[3]|max_length[100]',
            'descripcion' => 'permit_empty|max_length[500]',
            'prioridad' => 'required|in_list[baja,media,alta]',
            'estado' => 'required|in_list[pendiente,en progreso,completada]',
            'fecha_vencimiento' => 'required|valid_date[Y-m-d]'
        ];

        $messages = [
            'id_usuario' => [
                'required' => 'Debe seleccionar un usuario.'
            ],
            'titulo' => [
                'required' => 'Debe ingresar un título.',
                'min_length' => 'El título debe tener al menos 3 caracteres.',
                'max_length' => 'El título no puede superar los 100 caracteres.'
            ],
            'descripcion' => [
                'max_length' => 'La descripción no puede superar los 500 caracteres.'
            ],
            'prioridad' => [
                'required' => 'Debe seleccionar una prioridad.',
                'in_list' => 'La prioridad seleccionada no es válida.'
            ],
            'estado' => [
                'required' => 'Debe seleccionar un estado.',
                'in_list' => 'El estado seleccionado no es válido.'
            ],
            'fecha_vencimiento' => [
                'required' => 'Debe ingresar una fecha de vencimiento.',
                'valid_date' => 'La fecha ingresada no es válida. Formato permitido: YYYY-MM-DD.'
            ]
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // === VALIDACIÓN FECHA EXTRA ===
        $fecha = $this->request->getPost('fecha_vencimiento');

        if ($fecha == "0000-00-00") {
            return redirect()->back()->withInput()->with('error', 'La fecha no puede ser 0000-00-00.');
        }

        $hoy = date('Y-m-d');
        $min = date('Y-m-d', strtotime('+1 day'));
        $max = date('Y-m-d', strtotime('+1 year'));

        if ($fecha < $min) {
            return redirect()->back()->withInput()->with('error', 'La fecha debe ser posterior a hoy.');
        }

        if ($fecha > $max) {
            return redirect()->back()->withInput()->with('error', 'La fecha no puede superar un año desde hoy.');
        }

        // GUARDAR
        $this->tareaModel->insert([
            'id_usuario' => $this->request->getPost('id_usuario'),
            'titulo' => $this->request->getPost('titulo'),
            'descripcion' => $this->request->getPost('descripcion'),
            'fecha_creacion' => date('Y-m-d'),
            'fecha_vencimiento' => $fecha,
            'estado' => $this->request->getPost('estado'),
            'prioridad' => $this->request->getPost('prioridad'),
        ]);

        return redirect()->to('/tareas')->with('success', 'Tarea creada correctamente.');
    }


    public function edit($id)
    {
        $data['tarea'] = $this->tareaModel->find($id);
        $data['usuarios'] = $this->usuarioModel->findAll();

        if (!$data['tarea']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Tarea no encontrada");
        }

        return view('tareas/edit', $data);
    }


    public function update($id)
    {
        // VALIDACIONES IGUALES A CREATE
        $rules = [
            'id_usuario' => 'required|integer',
            'titulo' => 'required|min_length[3]|max_length[100]',
            'descripcion' => 'permit_empty|max_length[500]',
            'prioridad' => 'required|in_list[baja,media,alta]',
            'estado' => 'required|in_list[pendiente,en progreso,completada]',
            'fecha_vencimiento' => 'required|valid_date[Y-m-d]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $fecha = $this->request->getPost('fecha_vencimiento');

        $min = date('Y-m-d', strtotime('+1 day'));
        $max = date('Y-m-d', strtotime('+1 year'));

        if ($fecha < $min) {
            return redirect()->back()->withInput()->with('error', 'La fecha debe ser posterior a hoy.');
        }

        if ($fecha > $max) {
            return redirect()->back()->withInput()->with('error', 'La fecha no puede superar un año.');
        }

        $this->tareaModel->update($id, [
            'id_usuario' => $this->request->getPost('id_usuario'),
            'titulo' => $this->request->getPost('titulo'),
            'descripcion' => $this->request->getPost('descripcion'),
            'fecha_vencimiento' => $fecha,
            'estado' => $this->request->getPost('estado'),
            'prioridad' => $this->request->getPost('prioridad'),
        ]);

        return redirect()->to('/tareas')->with('success', 'Tarea actualizada correctamente.');
    }


    
    public function delete($id)
    {
    $tarea = $this->tareaModel->find($id);

    if (!$tarea) {
        return redirect()->to('/tareas')->with('error', 'La tarea no existe.');
    }

    // NO PERMITIR ELIMINAR SI ESTÁ PENDIENTE O EN PROGRESO
    if (in_array($tarea['estado'], ['pendiente', 'en progreso'])) {
        return redirect()->to('/tareas')->with('error', 'No se puede eliminar una tarea que está pendiente o en progreso.');
    }

    $this->tareaModel->delete($id);

    return redirect()->to('/tareas')->with('success', 'Tarea eliminada correctamente.');
}

}

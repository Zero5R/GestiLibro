<?php

namespace App\Controllers;

use App\Models\CategoriaModel;
use CodeIgniter\Controller;

class CategoriaController extends Controller
{
    protected $categoriaModel;

    public function __construct()
    {
        $this->categoriaModel = new CategoriaModel();
    }

    public function index()
    {
        $model = new CategoriaModel();
        $data['categorias'] = $model->findAll();
        return view('categorias/index', $data);
    }

    public function create()
    {
        return view('categorias/create');
    }

    public function store()
    {
        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
        ];

        if (! $this->categoriaModel->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $this->categoriaModel->errors());
        }

        return redirect()->to('/categorias')->with('success', 'Categoría creada correctamente.');
    }

    public function edit($id)
    {
        $data['categoria'] = $this->categoriaModel->find($id);
        return view('categorias/edit', $data);
    }

    public function update($id)
    {
        $data = [
            'id_categoria' => $id,
            'nombre'       => $this->request->getPost('nombre'),
            'descripcion'  => $this->request->getPost('descripcion'),
        ];

        if (! $this->categoriaModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->categoriaModel->errors());
        }

        return redirect()->to('/categorias')->with('success', 'Categoría actualizada correctamente.');
    }

    public function delete($id)
    {
        $db = \Config\Database::connect();

        // Verificar si hay libros asociados
        $libros = $db->table('Libro')->where('id_categoria', $id)->countAllResults();

        if ($libros > 0) {
            return redirect()->to('/categorias')
                ->with('error', 'No se puede eliminar la categoría porque tiene libros asociados.');
        }

        // Verificar préstamos asociados mediante libros
        $prestamos = $db->table('Prestamo')
            ->join('Libro', 'Libro.id_libro = Prestamo.id_libro')
            ->where('Libro.id_categoria', $id)
            ->countAllResults();

        if ($prestamos > 0) {
            return redirect()->to('/categorias')
                ->with('error', 'No se puede eliminar la categoría porque tiene préstamos asociados.');
        }

        // Eliminar si no tiene relaciones
        $this->categoriaModel->delete($id);

        return redirect()->to('/categorias')->with('success', 'Categoría eliminada correctamente.');
    }
}

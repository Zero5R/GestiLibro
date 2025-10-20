<?php

namespace App\Models;

use CodeIgniter\Model;

class LibroModel extends Model
{
    protected $table = 'Libro';
    protected $primaryKey = 'id_libro';
    protected $allowedFields = ['titulo', 'autor', 'editorial', 'anio', 'disponibilidad', 'id_categoria'];
    protected $returnType = 'array';
    protected $useTimestamps = false;

    // 🔹 Relación: Obtener libros con su categoría
    public function conCategoria()
    {
        return $this->select('Libro.*, Categoria.nombre AS nombre_categoria')
                    ->join('Categoria', 'Categoria.id_categoria = Libro.id_categoria', 'left')
                    ->findAll();
    }
}

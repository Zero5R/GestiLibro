<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoriaModel extends BaseModel
{
    protected $table = 'Categoria';
    protected $primaryKey = 'id_categoria';
    protected $allowedFields = ['nombre', 'descripcion'];
    protected $returnType = 'array';

    protected $observers = [
        \App\Observers\AuditObserver::class,
    ];

    protected $validationRules = [
        'id_categoria' => 'permit_empty', // Necesario para validación en update
        'nombre' => 'required|min_length[3]|max_length[100]|alpha_numeric_space|is_unique[Categoria.nombre,id_categoria,{id_categoria}]',
        'descripcion' => 'permit_empty|max_length[255]',
    ];

    protected $validationMessages = [
        'nombre' => [
            'required'            => 'El nombre de la categoría es obligatorio.',
            'min_length'          => 'El nombre debe tener al menos 3 caracteres.',
            'max_length'          => 'El nombre no puede superar los 100 caracteres.',
            'alpha_numeric_space' => 'El nombre solo puede contener letras, números y espacios.',
            'is_unique'           => 'Ya existe una categoría con este nombre.'
        ],
        'descripcion' => [
            'max_length' => 'La descripción no puede superar los 255 caracteres.',
        ]
    ];
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class AuditoriaModel extends Model
{
    protected $table = 'Auditoria';
    protected $primaryKey = 'id_auditoria';
    protected $allowedFields = ['id_usuario', 'id_libro', 'accion', 'descripcion', 'estado', 'fecha'];
    protected $returnType = 'array';
    protected $useTimestamps = false;

    // 🔹 Obtener auditorías con usuario y libro
    public function conDetalles()
    {
        return $this->select('Auditoria.*, Usuario.nombre as usuario, Libro.titulo as libro')
                    ->join('Usuario', 'Usuario.id_usuario = Auditoria.id_usuario')
                    ->join('Libro', 'Libro.id_libro = Auditoria.id_libro', 'left')
                    ->findAll();
    }
}

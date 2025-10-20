<?php

namespace App\Models;

use CodeIgniter\Model;

class PrestamoModel extends Model
{
    protected $table = 'Prestamo';
    protected $primaryKey = 'id_prestamo';
    protected $allowedFields = ['id_usuario', 'id_libro', 'fecha_prestamo', 'fecha_devolucion', 'estado'];
    protected $returnType = 'array';
    protected $useTimestamps = false;

    // 🔹 Obtener préstamos con info del usuario y libro
    public function conDetalles()
    {
        return $this->select('Prestamo.*, Usuario.nombre AS nombre_usuario, Libro.titulo AS titulo_libro')
                    ->join('Usuario', 'Usuario.id_usuario = Prestamo.id_usuario')
                    ->join('Libro', 'Libro.id_libro = Prestamo.id_libro')
                    ->orderBy('Prestamo.id_prestamo', 'DESC')
                    ->findAll();
    }
}



<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table = 'Usuario';
    protected $primaryKey = 'id_usuario';
    protected $allowedFields = ['nombre', 'apellido', 'correo', 'contrasena', 'id_rol'];
    protected $returnType = 'array';
    protected $useTimestamps = false;

    // Obtener el rol del usuario
    public function obtenerRol()
    {
        return $this->join('Rol', 'Rol.id_rol = Usuario.id_rol')
                    ->select('Usuario.*, Rol.nombre as rol')
                    ->findAll();
    }
}

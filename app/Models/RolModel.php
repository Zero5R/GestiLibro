<?php

namespace App\Models;

use CodeIgniter\Model;

class RolModel extends Model
{
    protected $table = 'Rol';
    protected $primaryKey = 'id_rol';
    protected $allowedFields = ['nombre'];
    protected $returnType = 'array';
    protected $useTimestamps = false;
}

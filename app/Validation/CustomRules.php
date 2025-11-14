<?php

namespace App\Validation;

class CustomRules
{
   

    // Validar formato YYYY-MM-DD
    public function valid_date(string $str): bool
    {
        $parts = explode('-', $str);
        if (count($parts) !== 3) return false;

        [$y, $m, $d] = $parts;

        return checkdate((int) $m, (int) $d, (int) $y);
    }

    // Fecha estrictamente mayor a hoy
    public function date_not_past(string $str): bool
    {
        if (!$this->valid_date($str)) return false;

        $today = date('Y-m-d');
        return $str > $today;
    }

    // No más de 5 años hacia adelante
    public function date_not_too_far(string $str): bool
    {
        if (!$this->valid_date($str)) return false;

        $max = date('Y-m-d', strtotime('+5 years'));
        return $str <= $max;
    }


    

    // Solo letras y espacios
    public function alphaSpaces(string $str, string &$error = null): bool
    {
        if (!preg_match('/^[\pL\s]+$/u', $str)) {
            $error = 'El campo solo puede contener letras.';
            return false;
        }
        return true;
    }

    // Contraseña fuerte: mínimo 6 caracteres, 1 letra, 1 número
    public function strongPassword(string $str, string &$error = null): bool
    {
        if (!preg_match('/^(?=.*[a-zA-Z])(?=.*\d).{6,}$/', $str)) {
            $error = 'La contraseña debe tener mínimo 6 caracteres e incluir números y letras.';
            return false;
        }
        return true;
    }

    // Username solo letras/números/puntos/guiones
    public function validUsername(string $str, string &$error = null): bool
    {
        if (!preg_match('/^[a-zA-Z0-9._-]+$/', $str)) {
            $error = 'El username solo puede contener letras, números, puntos, guiones y guion bajo.';
            return false;
        }
        return true;
    }
}

<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;
use App\Validation\CustomRules; 


class Validation extends BaseConfig
{
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
        \App\Validation\CustomRules::class, 
    ];

    public array $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    public array $rules = [];

public array $messages = [
    'tareas' => [
        'fecha_vencimiento' => [
            'valid_date' => 'La fecha no es válida.',
            'date_not_past' => 'La fecha debe ser posterior a hoy.',
            'date_not_too_far' => 'La fecha no puede ser superior a 5 años desde hoy.',
        ],
    ],
];

}

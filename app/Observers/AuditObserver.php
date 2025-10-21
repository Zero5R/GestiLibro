<?php
// app/Observers/AuditObserver.php
namespace App\Observers;

use CodeIgniter\Database\Config;

class AuditObserver implements ObserverInterface
{
    public function handle(string $evento, array $payload): void
    {   
        $db = \Config\Database::connect();
        $db->table('auditorias')->insert([
            'entidad'     => $payload['model'],
            'entidad_id'  => $payload['id'] ?? null,
            'accion'      => $evento,
            'detalle'     => json_encode($payload['data'] ?? []),
            'user_id'     => session()->get('user')['id_usuario'] ?? null,
            'fecha'       => date('Y-m-d H:i:s'),
        ]);
    }
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class ChatModel extends Model
{
    protected $table = 'chats';
    protected $primaryKey = 'id_chat';

    protected $allowedFields = [
        'id_order',
        'id_pengguna',
        'id_penyedia',
        'pesan_pengguna',
        'pesan_penyedia'
    ];

    protected $useTimestamps = false;

    public function getByOrder($orderId)
    {
        return $this->where('id_order', $orderId)
                    ->orderBy('waktu_kirim', 'ASC')
                    ->findAll();
    }
}

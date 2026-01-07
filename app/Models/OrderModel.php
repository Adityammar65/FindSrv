<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id_order';

    protected $allowedFields = [
        'id_pencari',
        'id_service',
        'deskripsi_permintaan',
        'status_pesanan',
        'tanggal_order'
    ];

    protected $useTimestamps = false;
}

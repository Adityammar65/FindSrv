<?php

namespace App\Models;

use CodeIgniter\Model;

class AnalyticModel extends Model
{
    protected $table      = 'analytics';
    protected $primaryKey = 'id_analytic';

    protected $allowedFields = [
        'id_service',
        'jumlah_dilihat',
        'jumlah_pesanan'
    ];
}

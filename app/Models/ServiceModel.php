<?php

namespace App\Models;

use CodeIgniter\Model;

class ServiceModel extends Model
{
    protected $table      = 'services';
    protected $primaryKey = 'id_service';

    protected $allowedFields = [
        'id_penyedia',
        'judul_jasa',
        'deskripsi_jasa',
        'harga',
        'kategori',
        'gambar_layanan'
    ];
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class RatingModel extends Model
{
    protected $table            = 'ratings';
    protected $primaryKey       = 'id_rating';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_order',
        'id_penulis',
        'skor_bintang',
        'ulasan_teks',
        'tanggal_ulasan'
    ];

    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function hasReviewed($orderId, $userId)
    {
        return $this->where('id_order', $orderId)
                    ->where('id_penulis', $userId)
                    ->first() !== null;
    }

    public function getReviewByOrderAndUser($orderId, $userId)
    {
        return $this->where('id_order', $orderId)
                    ->where('id_penulis', $userId)
                    ->first();
    }

    public function getOrderReviews($orderId)
    {
        return $this->where('id_order', $orderId)
                    ->orderBy('tanggal_ulasan', 'DESC')
                    ->findAll();
    }

    public function getRatingsByService($serviceId)
    {
        return $this->select('ratings.*, users.username, services.judul_jasa')
                    ->join('orders', 'orders.id_order = ratings.id_order', 'left')
                    ->join('services', 'services.id_service = orders.id_service', 'left')
                    ->join('users', 'users.id_user = ratings.id_penulis', 'left')
                    ->where('services.id_service', $serviceId)
                    ->orderBy('ratings.tanggal_ulasan', 'DESC')
                    ->findAll();
    }
}

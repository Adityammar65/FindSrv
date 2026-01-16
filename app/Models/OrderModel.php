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

    /**
     * Get orders with review status
     * 
     * @param int $userId
     * @param string $role 'pengguna' or 'penyedia'
     * @param int $perPage
     * @return array
     */
    public function getOrdersWithReviewStatus($userId, $role)
    {
        $db = \Config\Database::connect();
        
        $builder = $db->table('orders')
            ->select('
                orders.*,
                services.judul_jasa,
                services.gambar_layanan,
                penyedia.username AS username_penyedia,
                penyedia.email AS email_penyedia,
                pencari.username AS username_pencari,
                pencari.email AS email_pencari,
                ratings.id_rating,
                CASE WHEN ratings.id_rating IS NOT NULL THEN 1 ELSE 0 END AS has_review
            ', false)
            ->join('services', 'services.id_service = orders.id_service', 'left')
            ->join('users AS penyedia', 'penyedia.id_user = services.id_penyedia', 'left')
            ->join('users AS pencari', 'pencari.id_user = orders.id_pencari', 'left')
            ->join('ratings', 'ratings.id_order = orders.id_order AND ratings.id_penulis = ' . $userId, 'left');
        
        if ($role === 'pengguna') {
            $builder->where('orders.id_pencari', $userId);
        } else {
            $builder->where('services.id_penyedia', $userId);
        }
        
        return $builder
            ->orderBy('orders.tanggal_order', 'DESC')
            ->get()
            ->getResultArray();
    }
}

<?php

namespace App\Controllers;

use App\Models\ChatModel;
use App\Models\OrderModel;

class Chat extends BaseController
{
    protected $chatModel;
    protected $orderModel;

    public function __construct()
    {
        $this->chatModel  = new ChatModel();
        $this->orderModel = new OrderModel();
    }

    // MAIN VIEW
    public function index()
    {
        $session = session();
        $idUser = $session->get('id_user');
        $role = $session->get('role');
        
        if (!$idUser) {
            return redirect()->to('/login')
                ->with('error', 'Silakan login terlebih dahulu');
        }
        
        $perPage = 20;
        
        $builder = $this->orderModel
            ->select('
                orders.*,
                services.judul_jasa,
                services.gambar_layanan,
                penyedia.username AS username_penyedia,
                penyedia.email AS email_penyedia,
                pencari.username AS username_pencari,
                pencari.email AS email_pencari
            ')
            ->join('services', 'services.id_service = orders.id_service', 'left')
            ->join('users AS penyedia', 'penyedia.id_user = services.id_penyedia', 'left')
            ->join('users AS pencari', 'pencari.id_user = orders.id_pencari', 'left');
        
        if ($role === 'pengguna') {
            $builder->where('orders.id_pencari', $idUser);
        } else {
            $builder->where('services.id_penyedia', $idUser);
        }
        
        $orders = $builder
            ->orderBy('orders.tanggal_order', 'DESC')
            ->paginate($perPage);
        
        return view('chat/index', [
            'orders' => $orders,
            'pager'  => $this->orderModel->pager,
            'role'   => $role
        ]);
    }

    // DETAIL VIEW
    public function detail($orderId)
    {
        $session = session();
        $currentUserId = $session->get('id_user');
        $role = $session->get('role');

        if (!$currentUserId) {
            return redirect()->to('/login');
        }

        $db = \Config\Database::connect();
        $chatModel = new ChatModel();

        $builder = $db->table('orders');
        $order = $builder
            ->select('orders.*, services.judul_jasa, services.id_penyedia')
            ->join('services', 'services.id_service = orders.id_service', 'left')
            ->where('orders.id_order', $orderId)
            ->get()
            ->getRowArray();

        if (!$order) {
            return redirect()->to('/')->with('error', 'Order tidak ditemukan');
        }

        if ($order['id_pencari'] != $currentUserId && $order['id_penyedia'] != $currentUserId) {
            return redirect()->to('/')->with('error', 'Anda tidak memiliki akses ke chat ini');
        }

        $chats = $chatModel
            ->where('id_order', $orderId)
            ->orderBy('id_chat', 'ASC')
            ->findAll();

        $data = [
            'order' => $order,
            'chats' => $chats
        ];

        return view('chat/detail', $data);
    }

    // SEND CHAT
    public function send($orderId = null)
    {
        $session = session();
        $currentUserId = $session->get('id_user');
        $role = $session->get('role');

        if (!$currentUserId) {
            return redirect()->to('/login');
        }

        $db = \Config\Database::connect();

        if ($orderId === null) {
            $orderId = $this->request->getPost('order_id');
        }

        $message = $this->request->getPost('message');
        $userId = $this->request->getPost('user_id');
        $providerId = $this->request->getPost('provider_id');

        $orderBuilder = $db->table('orders');
        $order = $orderBuilder->where('id_order', $orderId)->get()->getRowArray();
        
        if (!$order) {
            return redirect()->back()->with('error', 'Order tidak ditemukan');
        }

        $data = [
            'id_order' => $orderId,
            'id_pengguna' => $userId,
            'id_penyedia' => $providerId,
            'waktu_kirim' => date('H:i:s')
        ];

        if ($role === 'pengguna') {
            $data['pesan_pengguna'] = $message;
            $data['pesan_penyedia'] = '';
        } else {
            $data['pesan_penyedia'] = $message;
            $data['pesan_pengguna'] = '';
        }

        $chatBuilder = $db->table('chats');
        $chatBuilder->insert($data);

        return $this->detail($orderId);
    }

    // VIEW CHAT
    public function view($orderId)
    {
        $order = $this->orderModel
            ->select('orders.*, services.judul_jasa, services.id_penyedia')
            ->join('services', 'services.id_service = orders.id_service', 'left')
            ->find($orderId);
        
        if (!$order) {
            return redirect()->back();
        }
        
        return view('chat/detail', [
            'order' => $order,
            'chats' => $this->chatModel->getByOrder($orderId),
            'role'  => session()->get('role'),
            'userId'=> session()->get('user_id')
        ]);
    }
}
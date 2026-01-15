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
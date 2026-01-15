<?php

namespace App\Controllers;

use App\Models\ServiceModel;
use App\Models\OrderModel;
use App\Models\ChatModel;
use App\Models\AnalyticModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Pages extends BaseController
{
    protected $serviceModel;
    protected $orderModel;
    protected $chatModel;
    protected $analyticModel;
    
    private const MAX_CATEGORIES = 3;
    private const MAX_FILE_SIZE = 5120;
    private const ALLOWED_IMAGE_TYPES = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
    private const UPLOAD_PATH = 'uploads/jasa';

    public function __construct()
    {
        $this->serviceModel = new ServiceModel();
        $this->orderModel = new OrderModel();
        $this->chatModel = new ChatModel();
        $this->analyticModel = new AnalyticModel();
        
        helper(['text', 'form']);
    }

    // ==================== VIEW PAGES ====================

    public function index(): string
    {
        return view('pages/welcoming');
    }

    public function home_pengguna(): string
    {
        return view('pages/pengguna/homepage_pengguna');
    }

    public function home_penyedia(): string
    {
        return view('pages/penyedia/homepage_penyedia');
    }

    // ==================== SERVICE MANAGEMENT ====================

    public function dashboardJasa()
    {
        $session = session();
        $idPenyedia = $session->get('id_user');

        if (!$idPenyedia) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        $services = $this->serviceModel
            ->select('services.*, COALESCE(analytics.jumlah_dilihat, 0) as views, COALESCE(analytics.jumlah_pesanan, 0) as orders')
            ->join('analytics', 'analytics.id_service = services.id_service', 'left')
            ->where('services.id_penyedia', $idPenyedia)
            ->orderBy('services.id_service', 'DESC')
            ->findAll();

        $data = [
            'user' => [
                'username' => $session->get('username'),
                'email' => $session->get('email'),
                'role' => $session->get('role'),
            ],
            'services' => $services
        ];

        return view('pages/penyedia/dashboard_jasa', $data);
    }

    public function simpanJasa()
    {
        $session = session();
        $idPenyedia = $session->get('id_user');

        if (!$idPenyedia) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        $kategori = $this->request->getPost('kategori');
        if (!$kategori || !is_array($kategori) || count($kategori) > self::MAX_CATEGORIES) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Pilih minimal 1 dan maksimal ' . self::MAX_CATEGORIES . ' kategori');
        }

        $judulJasa = trim($this->request->getPost('judul_jasa'));
        $deskripsiJasa = trim($this->request->getPost('deskripsi_jasa'));

        if (empty($judulJasa)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Judul jasa harus diisi');
        }

        $data = [
            'id_penyedia' => $idPenyedia,
            'judul_jasa' => esc($judulJasa),
            'deskripsi_jasa' => esc($deskripsiJasa),
            'kategori' => implode(',', array_map('esc', $kategori)),
        ];

        $imageResult = $this->handleImageUpload('gambar_layanan');
        if ($imageResult['error']) {
            return redirect()->back()
                ->withInput()
                ->with('error', $imageResult['message']);
        }

        if ($imageResult['filename']) {
            $data['gambar_layanan'] = $imageResult['filename'];
        }

        try {
            $this->serviceModel->insert($data);
            return redirect()->to('dashboard')->with('success', 'Jasa berhasil ditambahkan');
        } catch (\Exception $e) {
            if ($imageResult['filename']) {
                $this->deleteImage($imageResult['filename']);
            }
            log_message('error', 'Failed to insert service: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan jasa. Silakan coba lagi.');
        }
    }

    public function updateJasa($id)
    {
        $session = session();
        $userId = $session->get('id_user');

        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        $service = $this->serviceModel->find($id);
        if (!$service || $service['id_penyedia'] != $userId) {
            return redirect()->to('dashboard')->with('error', 'Akses tidak valid');
        }

        $kategori = $this->request->getPost('kategori');
        if (!$kategori || !is_array($kategori) || count($kategori) > self::MAX_CATEGORIES) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Pilih minimal 1 dan maksimal ' . self::MAX_CATEGORIES . ' kategori');
        }

        $judulJasa = trim($this->request->getPost('judul_jasa'));
        $deskripsiJasa = trim($this->request->getPost('deskripsi_jasa'));

        if (empty($judulJasa)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Judul jasa harus diisi');
        }

        $data = [
            'judul_jasa' => esc($judulJasa),
            'deskripsi_jasa' => esc($deskripsiJasa),
            'kategori' => implode(',', array_map('esc', $kategori)),
        ];

        $imageResult = $this->handleImageUpload('gambar_layanan');
        if ($imageResult['error']) {
            return redirect()->back()
                ->withInput()
                ->with('error', $imageResult['message']);
        }

        if ($imageResult['filename']) {
            if (!empty($service['gambar_layanan'])) {
                $this->deleteImage($service['gambar_layanan']);
            }
            $data['gambar_layanan'] = $imageResult['filename'];
        }

        try {
            $this->serviceModel->update($id, $data);
            return redirect()->to('dashboard')->with('success', 'Jasa berhasil diperbarui');
        } catch (\Exception $e) {
            log_message('error', 'Failed to update service: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui jasa. Silakan coba lagi.');
        }
    }

    public function hapusJasa($id)
    {
        $session = session();
        $userId = $session->get('id_user');

        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        $service = $this->serviceModel->find($id);
        if (!$service || $service['id_penyedia'] != $userId) {
            return redirect()->to('dashboard')->with('error', 'Akses tidak valid');
        }

        $db = \Config\Database::connect();
        $db->transStart();

        try {
            $this->serviceModel->delete($id);
            if (!empty($service['gambar_layanan'])) {
                $this->deleteImage($service['gambar_layanan']);
            }

            $db->transComplete();

            if ($db->transStatus() === false) {
                throw new \Exception('Transaction failed');
            }

            return redirect()->to('dashboard')->with('success', 'Jasa berhasil dihapus');
        } catch (\Exception $e) {
            log_message('error', 'Failed to delete service: ' . $e->getMessage());
            return redirect()->to('dashboard')->with('error', 'Gagal menghapus jasa');
        }
    }

    // ==================== SEARCH & BROWSE ====================

    public function pencarian()
    {
        $keyword = trim($this->request->getGet('keyword'));
        $kategori = $this->request->getGet('kategori');
        $builder = $this->serviceModel
            ->select('services.*, users.username, COALESCE(analytics.jumlah_dilihat, 0) as views')
            ->join('users', 'users.id_user = services.id_penyedia', 'left')
            ->join('analytics', 'analytics.id_service = services.id_service', 'left');

        if (!empty($keyword)) {
            $builder->groupStart()
                ->like('services.judul_jasa', esc($keyword))
                ->orLike('services.deskripsi_jasa', esc($keyword))
                ->groupEnd();
        }

        if (!empty($kategori)) {
            $builder->like('services.kategori', esc($kategori));
        }

        $perPage = 12;
        $services = $builder->paginate($perPage);
        $pager = $builder->pager;

        $data = [
            'services' => $services,
            'pager' => $pager,
            'keyword' => $keyword,
            'selectedKategori' => $kategori,
            'categories' => $this->getCategories(),
        ];

        return view('pages/pengguna/pencarian', $data);
    }

    public function detailJasa($id)
    {
        $service = $this->serviceModel
            ->select('services.*, users.username, users.email')
            ->join('users', 'users.id_user = services.id_penyedia', 'left')
            ->find($id);

        if (!$service) {
            throw new PageNotFoundException('Jasa tidak ditemukan');
        }

        $this->incrementViewCount($id);
        $analytic = $this->analyticModel->where('id_service', $id)->first();

        $data = [
            'service' => $service,
            'analytic' => $analytic
        ];

        return view('pages/pengguna/detail_jasa', $data);
    }

    // ==================== ORDER MANAGEMENT ====================

    public function orderJasa()
    {
        $session = session();
        $idPencari = $session->get('id_user');

        if (!$idPencari) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        $idService = $this->request->getPost('id_service');
        $deskripsiPermintaan = trim($this->request->getPost('deskripsi_permintaan'));

        if (empty($idService) || empty($deskripsiPermintaan)) {
            return redirect()->back()->with('error', 'Semua field harus diisi');
        }

        $service = $this->serviceModel->find($idService);
        if (!$service) {
            return redirect()->to('pencarian')->with('error', 'Jasa tidak ditemukan');
        }

        if ($service['id_penyedia'] == $idPencari) {
            return redirect()->back()->with('error', 'Anda tidak dapat memesan jasa sendiri');
        }

        $db = \Config\Database::connect();
        $db->transStart();

        try {
            $this->orderModel->insert([
                'id_pencari' => $idPencari,
                'id_service' => $idService,
                'deskripsi_permintaan' => esc($deskripsiPermintaan),
                'status_pesanan' => 'dalam proses'
            ]);

            $this->incrementOrderCount($idService);

            $db->transComplete();

            if ($db->transStatus() === false) {
                throw new \Exception('Transaction failed');
            }

            return redirect()
                ->to('detail_jasa/' . $idService)
                ->with('success', 'Pesanan berhasil dikirim. Penyedia jasa akan segera menghubungi Anda.');
        } catch (\Exception $e) {
            log_message('error', 'Failed to create order: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal membuat pesanan. Silakan coba lagi.');
        }
    }

    public function batalkanOrder($orderId)
    {
        $session = session();
        $idUser = $session->get('id_user');
        $role = $session->get('role');
        
        if (!$idUser) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }
        
        $order = $this->orderModel->find($orderId);
        
        if (!$order) {
            return redirect()->back()->with('error', 'Pesanan tidak ditemukan');
        }
        
        if ($role === 'pengguna' && $order['id_pencari'] != $idUser) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk membatalkan pesanan ini');
        } elseif ($role === 'penyedia' && $order['id_penyedia'] != $idUser) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk membatalkan pesanan ini');
        }
        
        $this->orderModel->update($orderId, [
            'status_pesanan' => 'dibatalkan'
        ]);
        
        return redirect()->back()->with('success', 'Pesanan berhasil dibatalkan');
    }

    public function statusUpdate($orderId)
    {
        $session = session();
        $idUser = $session->get('id_user');
        $role = $session->get('role');
        
        if (!$idUser) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }
        
        $newStatus = $this->request->getPost('status');
        
        // Validate status
        $validStatuses = ['dalam proses', 'selesai', 'dibatalkan'];
        if (!in_array($newStatus, $validStatuses)) {
            return redirect()->back()->with('error', 'Status tidak valid');
        }
        
        // Get the order
        $order = $this->orderModel->find($orderId);
        
        if (!$order) {
            return redirect()->back()->with('error', 'Pesanan tidak ditemukan');
        }
        
        // Verify permission
        if ($role === 'penyedia') {
            if ($order['id_penyedia'] != $idUser) {
                return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengubah status pesanan ini');
            }
        } elseif ($role === 'pengguna') {
            if ($newStatus !== 'dibatalkan' || $order['id_pencari'] != $idUser) {
                return redirect()->back()->with('error', 'Anda hanya dapat membatalkan pesanan Anda sendiri');
            }
        }
        
        // Update the status
        $this->orderModel->update($orderId, [
            'status_pesanan' => $newStatus
        ]);
        
        $statusMessages = [
            'dalam proses' => 'Status pesanan diubah menjadi Dalam Proses',
            'selesai' => 'Pesanan berhasil diselesaikan',
            'dibatalkan' => 'Pesanan berhasil dibatalkan'
        ];
        
        return redirect()->back()->with('success', $statusMessages[$newStatus]);
    }

    public function daftarPesanan()
    {
        $session = session();
        $idProvider = $session->get('id_user');
        
        if (!$idProvider) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }
        
        $orders = $this->orderModel
            ->select('
                orders.*,
                services.judul_jasa,
                services.gambar_layanan,
                users.username AS username_pemesan,
                users.email AS email_pemesan
            ')
            ->join('services', 'services.id_service = orders.id_service', 'left')
            ->join('users', 'users.id_user = orders.id_pencari', 'left')
            ->where('services.id_penyedia', $idProvider)
            ->orderBy('orders.tanggal_order', 'DESC')
            ->findAll();
        
        return view('pages/penyedia/daftar_pesanan', [
            'orders' => $orders
        ]);
    }

    public function riwayat()
    {
        $session = session();
        $idUser = $session->get('id_user');
        $role = $session->get('role');
        
        if (!$idUser) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
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
        
        $pager = $this->orderModel->pager;
        
        return view('pages/riwayat/riwayat', [
            'orders' => $orders,
            'pager' => $pager,
            'role' => $role
        ]);
    }

    // ==================== ANALYTICS ====================

    public function analyticJasa($idService)
    {
        $session = session();
        $idProvider = $session->get('id_user');

        if (!$idProvider) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        $service = $this->serviceModel
            ->select('services.*, users.username')
            ->join('users', 'users.id_user = services.id_penyedia', 'left')
            ->where('services.id_service', $idService)
            ->where('services.id_penyedia', $idProvider)
            ->first();

        if (!$service) {
            throw new PageNotFoundException('Jasa tidak ditemukan');
        }

        $analytic = $this->analyticModel->where('id_service', $idService)->first();

        if (!$analytic) {
            $analytic = [
                'id_service' => $idService,
                'jumlah_dilihat' => 0,
                'jumlah_pesanan' => 0
            ];
        }

        return view('pages/penyedia/analisis', [
            'service' => $service,
            'analytic' => $analytic
        ]);
    }

    // ==================== HELPER METHODS ====================

    private function handleImageUpload($fieldName): array
    {
        $result = [
            'error' => false,
            'message' => '',
            'filename' => null
        ];

        $file = $this->request->getFile($fieldName);

        if (!$file || !$file->isValid()) {
            return $result;
        }

        if ($file->getSize() > (self::MAX_FILE_SIZE * 1024)) {
            $result['error'] = true;
            $result['message'] = 'Ukuran file maksimal ' . self::MAX_FILE_SIZE . ' KB';
            return $result;
        }

        if (!in_array($file->getMimeType(), self::ALLOWED_IMAGE_TYPES)) {
            $result['error'] = true;
            $result['message'] = 'Format file harus JPG, JPEG, PNG, atau WEBP';
            return $result;
        }

        $uploadPath = FCPATH . self::UPLOAD_PATH;
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        try {
            $filename = $file->getRandomName();
            $file->move($uploadPath, $filename);
            $result['filename'] = $filename;
        } catch (\Exception $e) {
            $result['error'] = true;
            $result['message'] = 'Gagal mengupload file';
            log_message('error', 'File upload error: ' . $e->getMessage());
        }

        return $result;
    }

    private function deleteImage($filename): bool
    {
        if (empty($filename)) {
            return false;
        }

        $filePath = FCPATH . self::UPLOAD_PATH . '/' . $filename;
        
        if (file_exists($filePath)) {
            try {
                return unlink($filePath);
            } catch (\Exception $e) {
                log_message('error', 'Failed to delete image: ' . $e->getMessage());
                return false;
            }
        }

        return false;
    }

    private function incrementViewCount($idService): void
    {
        try {
            $analytic = $this->analyticModel->where('id_service', $idService)->first();

            if ($analytic) {
                $this->analyticModel->update($analytic['id_analytic'], [
                    'jumlah_dilihat' => $analytic['jumlah_dilihat'] + 1
                ]);
            } else {
                $this->analyticModel->insert([
                    'id_service' => $idService,
                    'jumlah_dilihat' => 1,
                    'jumlah_pesanan' => 0
                ]);
            }
        } catch (\Exception $e) {
            log_message('error', 'Failed to increment view count: ' . $e->getMessage());
        }
    }

    private function incrementOrderCount($idService): void
    {
        try {
            $analytic = $this->analyticModel->where('id_service', $idService)->first();

            if ($analytic) {
                $this->analyticModel->update($analytic['id_analytic'], [
                    'jumlah_pesanan' => $analytic['jumlah_pesanan'] + 1
                ]);
            } else {
                $this->analyticModel->insert([
                    'id_service' => $idService,
                    'jumlah_dilihat' => 0,
                    'jumlah_pesanan' => 1
                ]);
            }
        } catch (\Exception $e) {
            log_message('error', 'Failed to increment order count: ' . $e->getMessage());
        }
    }

    private function getCategories(): array
    {
        return [
            'Web Development',
            'Software Development',
            'Mobile App Development',
            'WordPress & CMS',
            'UI / UX Design',
            'Graphic Design',
            'Logo & Branding',
            'Illustration',
            'Motion Graphic',
            '3D Design',
            'Content Writing',
            'Copywriting',
            'Technical Writing',
            'Translation',
            'Digital Marketing',
            'SEO / SEM',
            'Social Media Management',
            'Business Consulting',
            'Video Editing',
            'Voice Over',
            'Audio Production',
            'Data Entry',
            'Virtual Assistant',
            'Customer Support',
            'Project Management',
        ];
    }
}
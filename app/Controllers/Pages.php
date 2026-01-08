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
    
    // Configuration constants
    private const MAX_CATEGORIES = 3;
    private const MAX_FILE_SIZE = 5120; // 5MB in KB
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

    /**
     * Welcome/Landing page
     */
    public function index(): string
    {
        return view('pages/welcoming');
    }

    /**
     * User homepage
     */
    public function home_pengguna(): string
    {
        return view('pages/pengguna/homepage_pengguna');
    }

    /**
     * Provider homepage
     */
    public function home_penyedia(): string
    {
        return view('pages/penyedia/homepage_penyedia');
    }

    // ==================== SERVICE MANAGEMENT ====================

    /**
     * Provider dashboard with service listing
     */
    public function dashboardJasa()
    {
        $session = session();
        $idPenyedia = $session->get('id_user');

        if (!$idPenyedia) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        // Fetch services with analytics in single query
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

    /**
     * Create new service
     */
    public function simpanJasa()
    {
        $session = session();
        $idPenyedia = $session->get('id_user');

        if (!$idPenyedia) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        // Validate categories
        $kategori = $this->request->getPost('kategori');
        if (!$kategori || !is_array($kategori) || count($kategori) > self::MAX_CATEGORIES) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Pilih minimal 1 dan maksimal ' . self::MAX_CATEGORIES . ' kategori');
        }

        // Validate and sanitize inputs
        $judulJasa = trim($this->request->getPost('judul_jasa'));
        $deskripsiJasa = trim($this->request->getPost('deskripsi_jasa'));

        if (empty($judulJasa)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Judul jasa harus diisi');
        }

        // Prepare data
        $data = [
            'id_penyedia' => $idPenyedia,
            'judul_jasa' => esc($judulJasa),
            'deskripsi_jasa' => esc($deskripsiJasa),
            'kategori' => implode(',', array_map('esc', $kategori)),
        ];

        // Handle image upload
        $imageResult = $this->handleImageUpload('gambar_layanan');
        if ($imageResult['error']) {
            return redirect()->back()
                ->withInput()
                ->with('error', $imageResult['message']);
        }

        if ($imageResult['filename']) {
            $data['gambar_layanan'] = $imageResult['filename'];
        }

        // Insert service
        try {
            $this->serviceModel->insert($data);
            return redirect()->to('dashboard')->with('success', 'Jasa berhasil ditambahkan');
        } catch (\Exception $e) {
            // Delete uploaded image if database insert fails
            if ($imageResult['filename']) {
                $this->deleteImage($imageResult['filename']);
            }
            log_message('error', 'Failed to insert service: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan jasa. Silakan coba lagi.');
        }
    }

    /**
     * Update existing service
     */
    public function updateJasa($id)
    {
        $session = session();
        $userId = $session->get('id_user');

        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        // Verify ownership
        $service = $this->serviceModel->find($id);
        if (!$service || $service['id_penyedia'] != $userId) {
            return redirect()->to('dashboard')->with('error', 'Akses tidak valid');
        }

        // Validate categories
        $kategori = $this->request->getPost('kategori');
        if (!$kategori || !is_array($kategori) || count($kategori) > self::MAX_CATEGORIES) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Pilih minimal 1 dan maksimal ' . self::MAX_CATEGORIES . ' kategori');
        }

        // Validate and sanitize inputs
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

        // Handle new image upload
        $imageResult = $this->handleImageUpload('gambar_layanan');
        if ($imageResult['error']) {
            return redirect()->back()
                ->withInput()
                ->with('error', $imageResult['message']);
        }

        if ($imageResult['filename']) {
            // Delete old image
            if (!empty($service['gambar_layanan'])) {
                $this->deleteImage($service['gambar_layanan']);
            }
            $data['gambar_layanan'] = $imageResult['filename'];
        }

        // Update service
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

    /**
     * Delete service
     */
    public function hapusJasa($id)
    {
        $session = session();
        $userId = $session->get('id_user');

        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        // Verify ownership
        $service = $this->serviceModel->find($id);
        if (!$service || $service['id_penyedia'] != $userId) {
            return redirect()->to('dashboard')->with('error', 'Akses tidak valid');
        }

        // Use transaction for data integrity
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // Delete service (related records should cascade if properly configured)
            $this->serviceModel->delete($id);
            
            // Delete image file
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

    /**
     * Search services with filters
     */
    public function pencarian()
    {
        $keyword = trim($this->request->getGet('keyword'));
        $kategori = $this->request->getGet('kategori');
        
        // Build query
        $builder = $this->serviceModel
            ->select('services.*, users.username, COALESCE(analytics.jumlah_dilihat, 0) as views')
            ->join('users', 'users.id_user = services.id_penyedia', 'left')
            ->join('analytics', 'analytics.id_service = services.id_service', 'left');

        // Apply filters
        if (!empty($keyword)) {
            $builder->groupStart()
                ->like('services.judul_jasa', esc($keyword))
                ->orLike('services.deskripsi_jasa', esc($keyword))
                ->groupEnd();
        }

        if (!empty($kategori)) {
            $builder->like('services.kategori', esc($kategori));
        }

        // Pagination
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

    /**
     * View service details
     */
    public function detailJasa($id)
    {
        // Fetch service with provider info
        $service = $this->serviceModel
            ->select('services.*, users.username, users.email')
            ->join('users', 'users.id_user = services.id_penyedia', 'left')
            ->find($id);

        if (!$service) {
            throw new PageNotFoundException('Jasa tidak ditemukan');
        }

        // Increment view count (use proper parameterized query)
        $this->incrementViewCount($id);

        // Fetch current analytics
        $analytic = $this->analyticModel->where('id_service', $id)->first();

        $data = [
            'service' => $service,
            'analytic' => $analytic
        ];

        return view('pages/pengguna/detail_jasa', $data);
    }

    // ==================== ORDER MANAGEMENT ====================

    /**
     * Create new order
     */
    public function orderJasa()
    {
        $session = session();
        $idPencari = $session->get('id_user');

        if (!$idPencari) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        $idService = $this->request->getPost('id_service');
        $deskripsiPermintaan = trim($this->request->getPost('deskripsi_permintaan'));

        // Validate inputs
        if (empty($idService) || empty($deskripsiPermintaan)) {
            return redirect()->back()->with('error', 'Semua field harus diisi');
        }

        // Verify service exists
        $service = $this->serviceModel->find($idService);
        if (!$service) {
            return redirect()->to('pencarian')->with('error', 'Jasa tidak ditemukan');
        }

        // Prevent ordering own service
        if ($service['id_penyedia'] == $idPencari) {
            return redirect()->back()->with('error', 'Anda tidak dapat memesan jasa sendiri');
        }

        // Use transaction
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // Insert order
            $this->orderModel->insert([
                'id_pencari' => $idPencari,
                'id_service' => $idService,
                'deskripsi_permintaan' => esc($deskripsiPermintaan),
                'status_pesanan' => 'dalam proses'
            ]);

            // Increment order count in analytics
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

    /**
     * List orders for provider
     */
    public function daftarPesanan()
    {
        $session = session();
        $idProvider = $session->get('id_user');

        if (!$idProvider) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        // Fetch orders with pagination
        $perPage = 20;
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
            ->paginate($perPage);

        $pager = $this->orderModel->pager;

        return view('pages/penyedia/daftar_pesanan', [
            'orders' => $orders,
            'pager' => $pager
        ]);
    }

    /**
     * Set price for order
     */
    public function setHarga()
    {
        $session = session();
        $idProvider = $session->get('id_user');

        if (!$idProvider) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        $idOrder = $this->request->getPost('id_order');
        $harga = $this->request->getPost('harga');

        // Validate inputs
        if (empty($idOrder) || empty($harga) || !is_numeric($harga) || $harga <= 0) {
            return redirect()->back()->with('error', 'Harga tidak valid');
        }

        // Verify order ownership
        $order = $this->orderModel
            ->select('orders.*, services.id_penyedia')
            ->join('services', 'services.id_service = orders.id_service', 'left')
            ->find($idOrder);

        if (!$order || $order['id_penyedia'] != $idProvider) {
            return redirect()->back()->with('error', 'Akses tidak valid');
        }

        // Update order
        try {
            $this->orderModel->update($idOrder, [
                'harga' => (float)$harga,
                'status_pesanan' => 'menunggu pembayaran'
            ]);

            return redirect()->back()->with('success', 'Harga berhasil ditetapkan');
        } catch (\Exception $e) {
            log_message('error', 'Failed to set price: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menetapkan harga');
        }
    }

    /**
     * View order history for user
     */
    public function riwayat()
    {
        $session = session();
        $idUser = $session->get('id_user');

        if (!$idUser) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        // Fetch orders with pagination
        $perPage = 20;
        $orders = $this->orderModel
            ->select('
                orders.*,
                services.judul_jasa,
                services.gambar_layanan,
                users.username AS username_penyedia
            ')
            ->join('services', 'services.id_service = orders.id_service', 'left')
            ->join('users', 'users.id_user = services.id_penyedia', 'left')
            ->where('orders.id_pencari', $idUser)
            ->orderBy('orders.tanggal_order', 'DESC')
            ->paginate($perPage);

        $pager = $this->orderModel->pager;

        return view('pages/pengguna/riwayat', [
            'orders' => $orders,
            'pager' => $pager
        ]);
    }

    // ==================== ANALYTICS ====================

    /**
     * View analytics for a service
     */
    public function analyticJasa($idService)
    {
        $session = session();
        $idProvider = $session->get('id_user');

        if (!$idProvider) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        // Fetch service with provider info
        $service = $this->serviceModel
            ->select('services.*, users.username')
            ->join('users', 'users.id_user = services.id_penyedia', 'left')
            ->where('services.id_service', $idService)
            ->where('services.id_penyedia', $idProvider)
            ->first();

        if (!$service) {
            throw new PageNotFoundException('Jasa tidak ditemukan');
        }

        // Fetch analytics
        $analytic = $this->analyticModel->where('id_service', $idService)->first();

        // If no analytics exist, create initial record
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

    // ==================== CHAT ====================

    /**
     * Send chat message
     */
    public function sendChat()
    {
        $session = session();
        $idPengirim = $session->get('id_user');

        if (!$idPengirim) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        $idPenerima = $this->request->getPost('id_penerima');
        $pesan = trim($this->request->getPost('pesan'));

        // Validate inputs
        if (empty($idPenerima) || empty($pesan)) {
            return redirect()->back()->with('error', 'Pesan tidak boleh kosong');
        }

        // Prevent sending message to self
        if ($idPengirim == $idPenerima) {
            return redirect()->back()->with('error', 'Tidak dapat mengirim pesan ke diri sendiri');
        }

        try {
            $this->chatModel->insert([
                'id_pengirim' => $idPengirim,
                'id_penerima' => $idPenerima,
                'pesan' => esc($pesan)
            ]);

            return redirect()->back()->with('success', 'Pesan terkirim');
        } catch (\Exception $e) {
            log_message('error', 'Failed to send chat: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengirim pesan');
        }
    }

    // ==================== HELPER METHODS ====================

    /**
     * Handle image upload with validation
     */
    private function handleImageUpload($fieldName): array
    {
        $result = [
            'error' => false,
            'message' => '',
            'filename' => null
        ];

        $file = $this->request->getFile($fieldName);

        // Check if file was uploaded
        if (!$file || !$file->isValid()) {
            return $result; // No file or invalid, but not an error
        }

        // Validate file size
        if ($file->getSize() > (self::MAX_FILE_SIZE * 1024)) {
            $result['error'] = true;
            $result['message'] = 'Ukuran file maksimal ' . self::MAX_FILE_SIZE . ' KB';
            return $result;
        }

        // Validate file type
        if (!in_array($file->getMimeType(), self::ALLOWED_IMAGE_TYPES)) {
            $result['error'] = true;
            $result['message'] = 'Format file harus JPG, JPEG, PNG, atau WEBP';
            return $result;
        }

        // Create upload directory if not exists
        $uploadPath = FCPATH . self::UPLOAD_PATH;
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        // Move file with random name
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

    /**
     * Delete image file
     */
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

    /**
     * Increment view count for a service
     */
    private function incrementViewCount($idService): void
    {
        try {
            $analytic = $this->analyticModel->where('id_service', $idService)->first();

            if ($analytic) {
                // Update existing record
                $this->analyticModel->update($analytic['id_analytic'], [
                    'jumlah_dilihat' => $analytic['jumlah_dilihat'] + 1
                ]);
            } else {
                // Create new record
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

    /**
     * Increment order count for a service
     */
    private function incrementOrderCount($idService): void
    {
        try {
            $analytic = $this->analyticModel->where('id_service', $idService)->first();

            if ($analytic) {
                // Update existing record
                $this->analyticModel->update($analytic['id_analytic'], [
                    'jumlah_pesanan' => $analytic['jumlah_pesanan'] + 1
                ]);
            } else {
                // Create new record
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

    /**
     * Get list of available categories
     * Consider moving this to a config file or database
     */
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
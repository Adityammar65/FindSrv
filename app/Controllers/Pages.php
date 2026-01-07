<?php

namespace App\Controllers;

use App\Models\ServiceModel;
use App\Models\OrderModel;
use App\Models\ChatModel;
use App\Models\AnalyticModel;

class Pages extends BaseController
{
    // CONSTRUCTOR
    protected $serviceModel;
    protected $orderModel;
    protected $analyticModel;

    public function __construct()
    {
        $this->serviceModel = new ServiceModel();
        $this->orderModel = new OrderModel();
        $this->analyticModel = new AnalyticModel();
    }

    // WELCOMING PAGE
    public function index(): string
    {
        return view('pages/welcoming');
    }

    // HOMEPAGE PENGGUNA
    public function home_pengguna(): string
    {
        return view('pages/pengguna/homepage_pengguna');
    }
    
    // HOMEPAGE PENYEDIA
    public function home_penyedia(): string
    {
        return view('pages/penyedia/homepage_penyedia');
    }

    // DASHBOARD PENYEDIA JASA
    public function dashboardJasa()
    {
        helper('text');
        $session = session();
        $idPenyedia = $session->get('id_user');

        $services = $this->serviceModel
            ->where('id_penyedia', $idPenyedia)
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

    // SIMPAN JASA
    public function simpanJasa()
    {
        $session = session();

        $kategori = $this->request->getPost('kategori');

        if (!$kategori || count($kategori) > 3) {
            return redirect()->back()->withInput()->with('error', 'Pilih maksimal 3 kategori');
        }

        $data = [
            'id_penyedia' => $session->get('id_user'),
            'judul_jasa' => $this->request->getPost('judul_jasa'),
            'deskripsi_jasa'  => trim($this->request->getPost('deskripsi_jasa')) ?: '',
            'kategori' => is_array($kategori) ? implode(',', $kategori) : $kategori,
        ];

        $gambar = $this->request->getFile('gambar_layanan');

        if ($gambar && $gambar->isValid() && !$gambar->hasMoved()) {
            $path = FCPATH . 'uploads/jasa';

            $nama = $gambar->getRandomName();
            $gambar->move($path, $nama);

            $data['gambar_layanan'] = $nama;
        }

        $this->serviceModel->insert($data);

        return redirect()->to('dashboard');
    }

    // UPDATE JASA
    public function updateJasa($id)
    {
        $session = session();
        $userId  = $session->get('id_user');
        $service = $this->serviceModel->find($id);

        if (!$service || $service['id_penyedia'] != $userId) {
            return redirect()->to('dashboard')
                ->with('error', 'Akses tidak valid');
        }

        $kategori = $this->request->getPost('kategori');

        if (!$kategori || count($kategori) > 3) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Pilih maksimal 3 kategori');
        }

        $data = [
            'judul_jasa' => trim($this->request->getPost('judul_jasa')),
            'kategori' => is_array($kategori) ? implode(',', $kategori) : $kategori,
            'deskripsi_jasa' => trim($this->request->getPost('deskripsi_jasa')),
        ];

        $gambar = $this->request->getFile('gambar_layanan');
        if ($gambar && $gambar->isValid() && !$gambar->hasMoved()) {
            $path = FCPATH . 'uploads/jasa';

            if (!empty($service['gambar_layanan'])) {
                $oldImage = $path . '/' . $service['gambar_layanan'];
                if (file_exists($oldImage)) {
                    unlink($oldImage);
                }
            }

            $namaGambar = $gambar->getRandomName();
            $gambar->move($path, $namaGambar);
            $data['gambar_layanan'] = $namaGambar;
        }

        $this->serviceModel->update($id, $data);

        return redirect()->to('dashboard');
    }

    // HAPUS JASA
    public function hapusJasa($id)
    {
        $session = session();
        $userId  = $session->get('id_user');

        $service = $this->serviceModel->find($id);

        if (!$service || $service['id_penyedia'] != $userId) {
            return redirect()->to('dashboard')
                ->with('error', 'Akses tidak valid');
        }

        if (!empty($service['gambar_layanan'])) {
            $path = FCPATH . 'uploads/jasa/' . $service['gambar_layanan'];
            if (file_exists($path)) {
                unlink($path);
            }
        }

        $this->serviceModel->delete($id);

        return redirect()->to('dashboard')
            ->with('success', 'Jasa berhasil dihapus');
    }

    // PENCARIAN
    public function pencarian()
    {
        helper('text');
        $keyword  = $this->request->getGet('keyword');
        $kategori = $this->request->getGet('kategori');

        $query = $this->serviceModel;

        if ($keyword) {
            $query = $query->like('judul_jasa', $keyword)
                        ->orLike('deskripsi_jasa', $keyword);
        }

        if ($kategori) {
            $query = $query->like('kategori', $kategori);
        }

        $data = [
            'services' => $query->findAll(),
            'keyword'  => $keyword,
            'selectedKategori' => $kategori,
            'categories' => [
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
            ],
        ];

        return view('pages/pengguna/pencarian', $data);
    }

    // DETAIL JASA
    public function detailJasa($id)
    {
        $service = $this->serviceModel
            ->select('services.*, users.username')
            ->join('users', 'users.id_user = services.id_penyedia')
            ->find($id);

        if (!$service) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Jasa tidak ditemukan');
        }

        $analytic = $this->analyticModel->where('id_service', $id)->first();

        if ($analytic) {
            $this->analyticModel
                ->where('id_service', $id)
                ->set('jumlah_dilihat', 'jumlah_dilihat + 1', false)
                ->update();
        } else {
            $this->analyticModel->insert([
                'id_service' => $id,
                'jumlah_dilihat' => 1,
                'jumlah_pesanan' => 0
            ]);
        }

        return view('pages/pengguna/detail_jasa', [
            'service' => $service
        ]);
    }

    // ORDER JASA
    public function orderJasa()
    {
        if (!session()->get('id_user')) {
            return redirect()->to('/login');
        }

        $orderModel = new OrderModel();

        $orderModel->insert([
            'id_pencari'            => $this->request->getPost('id_pencari'),
            'id_service'            => $this->request->getPost('id_service'),
            'deskripsi_permintaan'  => $this->request->getPost('deskripsi_permintaan'),
            'status_pesanan'        => 'dalam proses'
        ]);

        $idOrder = $orderModel->getInsertID();

        return redirect()->to('pages/pengguna/chat' . $idOrder);
    }

    // DAFTAR PESANAN
    public function daftarPesanan()
    {
        $orders = $this->orderModel
            ->select('orders.*, services.judul_jasa, users.username')
            ->join('services', 'services.id_service = orders.id_service')
            ->join('users', 'users.id_user = orders.id_pencari')
            ->where('services.id_penyedia', session()->get('id_user'))
            ->findAll();

        return view('pages/penyedia/daftar_pesanan', [
            'orders' => $orders
        ]);
    }

    // CHAT
    public function sendChat()
    {
        $this->chatModel->insert([
            'id_pengirim' => session()->get('id_user'),
            'id_penerima' => $this->request->getPost('id_penerima'),
            'pesan'       => $this->request->getPost('pesan')
        ]);

        return redirect()->back();
    }

    // SET HARGA
    public function setHarga()
    {
        $this->orderModel->update(
            $this->request->getPost('id_order'),
            [
                'harga'          => $this->request->getPost('harga'),
                'status_pesanan' => 'dalam proses'
            ]
        );

        return redirect()->back();
    }

    // ANALYTIC
    public function analyticJasa($idService)
    {
        $service = $this->serviceModel
            ->select('services.judul_jasa, services.id_service')
            ->where('services.id_service', $idService)
            ->first();

        if (!$service) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Jasa tidak ditemukan');
        }

        $analytic = $this->analyticModel
            ->where('id_service', $idService)
            ->first();

        return view('pages/penyedia/analisis', [
            'service'  => $service,
            'analytic' => $analytic
        ]);
    }
}
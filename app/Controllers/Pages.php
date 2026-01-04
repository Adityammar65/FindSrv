<?php

namespace App\Controllers;

use App\Models\ServiceModel;

class Pages extends BaseController
{
    protected $serviceModel;

    // CONSTRUCTOR
    public function __construct()
    {
        $this->serviceModel = new ServiceModel();
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

    // TAMBAH JASA
    public function createJasa()
    {
        return view('pages/penyedia/create_jasa');
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

        $gambar = $this->request->getFile('gambar_jasa');
        if ($gambar && $gambar->isValid()) {
            $namaGambar = $gambar->getRandomName();
            $gambar->move('uploads/jasa', $namaGambar);
            $data['gambar_layanan'] = $namaGambar;
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

        $gambar = $this->request->getFile('gambar_jasa');
        if ($gambar && $gambar->isValid() && !$gambar->hasMoved()) {

            if (!empty($service['gambar_layanan']) &&
                file_exists(FCPATH . 'uploads/jasa/' . $service['gambar_layanan'])) {
                unlink(FCPATH . 'uploads/jasa/' . $service['gambar_layanan']);
            }

            $namaGambar = $gambar->getRandomName();
            $gambar->move(FCPATH . 'uploads/jasa', $namaGambar);
            $data['gambar_layanan'] = $namaGambar;
        }

        $this->serviceModel->update($id, $data);

        return redirect()->to('dashboard');
    }
}

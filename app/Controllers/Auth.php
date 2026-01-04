<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login(): string
    {
        return view('auth/login');
    }

    public function register(): string
    {
        return view('auth/register');
    }

    public function saveRegister()
    {
        $userModel = new UserModel();

        $data = [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash(
                $this->request->getPost('password'),
                PASSWORD_DEFAULT
            ),
            'role'     => $this->request->getPost('role'),
        ];

        if (!$userModel->insert($data)) {
            return redirect()->back()->withInput();
        }

        session()->set([
            'id_user'    => $userModel->getInsertID(),
            'username'   => $data['username'],
            'email'      => $data['email'],
            'role'       => $data['role'],
            'isLoggedIn' => true
        ]);

        return redirect()->to(
            $data['role'] === 'penyedia'
            ? '/home_penyedia'
            : '/home_pengguna'
        );
    }

    public function loginProcess()
    {
        $session = session();
        $model   = new UserModel();

        $identifier = trim($this->request->getPost('identifier'));
        $password   = trim($this->request->getPost('password'));

        $user = $model->where('email', $identifier)
                      ->orWhere('username', $identifier)
                      ->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Email / Username salah');
        }

        if (!password_verify($password, $user['password'])) {
            return redirect()->back()->with('error', 'Password salah!');
        }

        $session->set([
            'id_user'        => $user['id_user'],
            'username'       => $user['username'],
            'email'          => $user['email'],
            'role'           => $user['role'],
            'foto_profil'  => $user['foto_profil'] ?? null,
            'isLoggedIn'     => true
        ]);

        return redirect()->to(
            $user['role'] === 'penyedia'
            ? '/home_penyedia'
            : '/home_pengguna'
        );
    }

    public function editProfile()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $user = (new UserModel())->find(session('id_user'));

        return view('auth/edit_profile', ['user' => $user]);
    }

    public function updateProfile()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $userModel = new UserModel();
        $session   = session();
        $id        = $session->get('id_user');

        $data = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
        ];

        if ($this->request->getPost('password')) {
            $data['password'] = password_hash(
                $this->request->getPost('password'),
                PASSWORD_DEFAULT
            );
        }

        $photo = $this->request->getFile('foto_profil');

        if ($photo && $photo->isValid() && !$photo->hasMoved()) {

            $newName = $photo->getRandomName();
            $path    = FCPATH . 'uploads/profile/';

            if (!is_dir($path)) {
                mkdir($path, 0775, true);
            }

            $photo->move($path, $newName);

            \Config\Services::image()
                ->withFile($path . $newName)
                ->fit(300, 300, 'center')
                ->save($path . $newName);

            $data['foto_profil'] = $newName;
        }

        $userModel->update($id, $data);

        $updated = $userModel->find($id);
        $session->set([
            'username' => $updated['username'],
            'email' => $updated['email'],
            'foto_profil' => $updated['foto_profil']
        ]);

        return redirect()->to(
            $updated['role'] === 'penyedia'
            ? '/home_penyedia'
            : '/home_pengguna'
        );
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

    public function kebijakanPrivasi()
    {
        $session = session();

        $data['user'] = [
            'role' => $session->get('role')
        ];

        return view('auth/kebijakan', $data);
    }

    public function syaratKetentuan()
    {
        $session = session();

        $data['user'] = [
            'role' => $session->get('role')
        ];

        return view('auth/syarat_ketentuan', $data);
    }

    public function pusatBantuan()
    {
        $session = session();

        $data['user'] = [
            'username' => $session->get('username'),
            'email' => $session->get('email'),
            'role' => $session->get('role')
        ];

        return view('auth/pusat_bantuan', $data);
    }
}

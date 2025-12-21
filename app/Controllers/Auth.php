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
            'username'=> $this->request->getPost('username'),
            'email'=> $this->request->getPost('email'),
            'password'=> password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'=> $this->request->getPost('role'),
        ];

        if ($userModel->insert($data)) {
            return redirect()->to('/login')->with('success', 'Registrasi Berhasil!');
        } else {
            return redirect()->back()->withInput();
        }
    }

    public function loginProcess()
    {
        $session = session();
        $model = new UserModel();

        $identifier = $this->request->getPost('identifier');
        $password = $this->request->getPost('password');

        $user = $model->where('email', $identifier)->first();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $sessionData = [
                    'id_user'=> $user['id_user'],
                    'username'=> $user['username'],
                    'email'=> $user['email'],
                    'role'=> $user['role'],
                    'isLoggedIn' => true
                ];
                $session->set($sessionData);

                if ($user['role'] == 'penyedia') {
                    return redirect()->to('/dashboard')->with('msg', 'Selamat datang di Dashboard Analytic');
                } else {
                    return redirect()->to('/rekomendasi');
                }

            } else {
                return redirect()->back()->with('error', 'Password Salah');
            }
        } else {
            return redirect()->back()->with('error', 'Email tidak ditemukan');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}

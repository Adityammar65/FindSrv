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
            if($data['role'] == 'pengguna') {
                return redirect()->to('/home_pengguna');
            } else {
                return redirect()->to('/home_penyedia');
            }   
        } else {
            return redirect()->back()->withInput();
        }
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
            'id_user'     => $user['id_user'],
            'username'    => $user['username'],
            'email'       => $user['email'],
            'role'        => $user['role'],
            'isLoggedIn'  => true
        ]);

        return redirect()->to(
            $user['role'] == 'penyedia'
            ? '/home_penyedia'
            : '/home_pengguna'
        );
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}

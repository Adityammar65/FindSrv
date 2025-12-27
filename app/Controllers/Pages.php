<?php

namespace App\Controllers;

class Pages extends BaseController
{
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
}

<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function index(): string
    {
        return view('pages/welcoming');
    }

    public function home(): string
    {
        return view('pages/homepage');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileeController extends Controller
{
    public function index()
    {
        return view('profile');
    }
}

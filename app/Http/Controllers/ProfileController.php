<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth_hash');
    }

    public function index()
    {
        //
        dd('Profile index');
    }
}

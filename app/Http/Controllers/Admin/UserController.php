<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    private $page = 1;
    private $perPage = 10;

    public function __construct()
    {
        $this->middleware('auth');

        if (session()->has('admin.user.perPage')) {
            $this->perPage = session()->get('admin.user.perPage', $this->perPage);
        } else {
            session('admin.user.perPage', $this->perPage);
        }
    }

    public function index(Request $request)
    {
        $users = User::all()->forPage($request->get('page', $this->page), $this->perPage);

        dd($users);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    private $page = 1;
    private $perPage = 10;

    public function index(Request $request)
    {
        $users = User::query()
            ->orderBy('name')
            ->forPage($request->get('page', $this->page), $this->perPage);

        dd($users);
    }
}

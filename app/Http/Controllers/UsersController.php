<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\UsersRepository;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'users' => 'array|min:1|max:10'
        ]);

        $repo = new UsersRepository();

        $users = $repo->fetch($request->get('users', []));

        return response()->json($users);
    }
}

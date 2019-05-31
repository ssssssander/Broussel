<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function users(Request $request) {
        $users = User::all();

        return response()->json([
            'status' => 'success',
            'users_data' => $users->toArray(),
        ]);
    }
}

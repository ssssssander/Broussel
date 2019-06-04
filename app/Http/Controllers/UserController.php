<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function buddies(Request $request) {
        $buddies = User::where([['is_buddy', true], ['status', 'accepted']]);

        return response()->json([
            'status' => 'success',
            'buddies_data' => $buddies->get()->toArray(),
        ]);
    }
}

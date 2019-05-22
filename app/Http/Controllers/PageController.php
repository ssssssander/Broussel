<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class PageController extends Controller
{
    public function app(Request $request) {
        $isAuth = Auth::check() ? 'true' : 'false';
        return view('app', compact('isAuth'));
    }

    public function pollAuth(Request $request) {
        $isAuth = Auth::check() ? 'true' : 'false';
        return response($isAuth);
    }

    public function dothing(Request $request) {
        return response()->json(
            $request->post()
        );
    }
}

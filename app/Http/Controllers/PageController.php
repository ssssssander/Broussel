<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function app() {
        $isAuth = Auth::check() ? 1 : 0;
        return view('app', compact('isAuth'));
    }
}

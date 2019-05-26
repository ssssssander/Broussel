<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class PageController extends Controller
{
    public function app(Request $request) {
        return view('app');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SiteController extends Controller
{
    public function site(Request $request) {
        $localeSegment = $request->segment(1);

        if ($localeSegment) {
            App::setLocale($localeSegment);
        }
        else {
            App::setLocale('nl');
        }

        return view('site');
    }
}

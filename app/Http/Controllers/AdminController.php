<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function getBuddiesToBeJudged(Request $request) {
        $buddiesToBeJudged = User::where([['role', 2], ['status', 'undecided']])->get();

        return response()->json([
            'status' => 'success',
            'buddies_to_be_judged_data' => $buddiesToBeJudged,
        ], 200);
    }

    public function setStatus(Request $request) {
        $buddy = User::find($request->id);
        $buddy->status = $request->status;
        $buddy->save();

        return response()->json(['status' => 'success'], 200);
    }
}

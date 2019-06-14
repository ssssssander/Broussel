<?php

namespace App\Http\Controllers;

use App\User;
use App\Mail\BuddyJudged;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function getBuddiesToBeJudged(Request $request) {
        $buddiesToBeJudged = User::where([['role', 'buddy'], ['status', 'undecided']])->get();

        return response()->json([
            'status' => 'success',
            'buddies_to_be_judged_data' => $buddiesToBeJudged,
        ], 200);
    }

    public function setStatus(Request $request) {
        $password = Str::random(8);
        $buddy = User::find($request->buddy_id);
        $buddy->status = $request->status;
        $buddy->password = Hash::make($password);
        $buddy->save();

        Mail::to($buddy)->send(new BuddyJudged($buddy->name, $buddy->status, $password));

        return response()->json(['status' => 'success'], 200);
    }
}

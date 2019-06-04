<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    public function register(Request $request) {
        $v = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password'  => 'required|string|min:8|max:255|confirmed',
        ]);

        if ($v->fails())  {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors(),
            ], 422);
        }

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['status' => 'success'], 200);
    }

    public function registerBuddy(Request $request) {
        $v = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'info'  => 'required|string|min:50|max:65000|',
            'available_times' => 'required|string|max:255|json',
        ]);

        if ($v->fails())  {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors(),
            ], 422);
        }

        $buddy = new User;
        $buddy->name = $request->name;
        $buddy->email = $request->email;
        $buddy->password =  Hash::make(Str::random(8)); // To be used later, when buddy is accepted
        $buddy->info = $request->info;
        $buddy->available_times = $request->available_times;
        $buddy->is_buddy = true;
        $buddy->status = 'accepted'; // Temp, actual value: 'undecided'
        $buddy->save();

        return response()->json(['status' => 'success'], 200);
    }

    public function login(Request $request) {
        $v = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password'  => 'required|string|max:255',
        ]);

        if ($v->fails())  {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors(),
            ], 422);
        }

        $credentials = $request->only('email', 'password');
        $token = $this->guard()->attempt($credentials);

        if ($token) {
            return response()->json(['status' => 'success'], 200)->header('Authorization', $token);
        }

        return response()->json(['error' => 'login_error'], 401);
    }

    public function logout() {
        $this->guard()->logout();

        return response()->json([
            'status' => 'success',
        ], 200);
    }

    public function user(Request $request) {
        $user = User::find(Auth::user()->id);

        return response()->json([
            'status' => 'success',
            'user_data' => $user,
        ]);
    }

    public function refresh() {
        $token = $this->guard()->refresh();

        if ($token) {
            return response()
                ->json(['status' => 'success'], 200)
                ->header('Authorization', $token);
        }

        return response()->json(['error' => 'refresh_token_error'], 401);
    }

    private function guard() {
        return Auth::guard();
    }
}

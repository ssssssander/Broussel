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
        $user->ip_address = $request->ip();
        $user->save();

        return response()->json(['status' => 'success'], 200);
    }

    public function registerBuddy(Request $request) {
        $availableTimes = json_decode($request->available_times, true);

        Validator::extend('divisible_by', function ($attribute, $value, $parameters, $validator) {
            return intval(explode(':', $value)[1]) % $parameters[0] === 0;
        });

        $requestValidator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'info'  => 'required|string|min:50|max:65000|',
            'available_times' => 'required|string|max:65000|json',
        ]);

        $availableTimesValidator = Validator::make($availableTimes, [
            '*.available' => 'required|boolean',
            '*.from' => 'required|date_format:H:i|divisible_by:5',
            '*.to' => 'required|date_format:H:i|after:*.from|divisible_by:5',
        ]);

        $availableTimesValidator->after(function ($validator) use($availableTimes) {
            $availableBools = array_column($availableTimes, 'available');
            $atLeastOne = count(array_filter($availableBools, function($var) { return $var; })) >= 1;

            if (!$atLeastOne) {
                $validator->errors()->add('at_least_one_day', trans('validation.custom.available_times.at_least_one'));
            }
        });

        if($requestValidator->fails() || $availableTimesValidator->fails()) {
            $errors = $requestValidator->errors()->merge($availableTimesValidator->errors());

            return response()->json([
                'status' => 'error',
                'errors' => $errors,
            ], 422);
        }

        $buddy = new User;
        $buddy->name = $request->name;
        $buddy->email = $request->email;
        $buddy->password =  Hash::make(Str::random(8)); // To be used later, when buddy is accepted???
        $buddy->ip_address = $request->ip();
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
        $user = User::find(Auth::id());

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

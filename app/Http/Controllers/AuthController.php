<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Mail\BuddySubmission;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;


class AuthController extends Controller
{
    use SendsPasswordResetEmails;
    use ResetsPasswords;

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
        $user->role = 'user';
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
            'motivation'  => 'required|string|min:50|max:65000',
            'nl'  => 'boolean',
            'fr'  => 'boolean',
            'en'  => 'boolean',
            'available_times' => 'required|string|max:65000|json',
        ]);

        $availableTimesValidator = Validator::make($availableTimes, [
            '*.available' => 'required|boolean',
            '*.from' => 'required|date_format:H:i|divisible_by:5',
            '*.to' => 'required|date_format:H:i|after:*.from|divisible_by:5',
        ]);

        $availableTimesValidator->after(function ($validator) use ($availableTimes) {
            $availableBools = array_column($availableTimes, 'available');
            $atLeastOne = count(array_filter($availableBools, function($var) { return $var; })) >= 1;

            if (!$atLeastOne) {
                $validator->errors()->add('at_least_one_day', trans('validation.custom.available_times.at_least_one_day'));
            }
        });

        $requestValidator->after(function ($validator) use ($request) {
            if (!$request->nl && !$request->fr && !$request->en) {
                $validator->errors()->add('at_least_one_lang', trans('validation.custom.*.at_least_one_lang'));
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
        $buddy->password =  null;
        $buddy->ip_address = $request->ip();
        $buddy->motivation = $request->motivation;
        $buddy->nl = $request->nl;
        $buddy->fr = $request->fr;
        $buddy->en = $request->en;
        $buddy->available_times = $request->available_times;
        $buddy->role = 'buddy';
        $buddy->status = 'undecided';
        $buddy->save();

        try {
            Mail::to(env('ADMIN_EMAIL'))->send(new BuddySubmission($buddy->name, $buddy->id));
        }
        catch(\Exception $e) {
            Log::error($e);
        }

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

        return response()->json(['status' => 'success'], 200);
    }

    public function user(Request $request) {
        $user = Auth::user();

        return response()->json([
            'status' => 'success',
            'data' => $user,
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

    public function forgotPassword(Request $request) {
        return $this->sendResetLinkEmail($request);
    }

    public function doReset(Request $request) {
        return $this->reset($request);
    }

    private function guard() {
        return Auth::guard();
    }
}

<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Image;

class UserController extends Controller
{
    public function findBuddies(Request $request) {
        Validator::extend('divisible_by', function ($attribute, $value, $parameters, $validator) {
            return intval(explode(':', $value)[1]) % $parameters[0] === 0;
        });

        $requestValidator = Validator::make($request->all(), [
            'date' => 'required|date_format:d/m/Y',
            'from' => 'required|date_format:H:i|divisible_by:5',
            'to'  => 'required|date_format:H:i|after:from|divisible_by:5',
        ]);

        if($requestValidator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $requestValidator->errors(),
            ], 422);
        }

        $buddies = User::where([['is_buddy', true], ['status', 'accepted']])->get()->toArray();
        $availableBuddies = [];

        foreach ($buddies as $buddy) {
            $availableTimes = json_decode($buddy['available_times'], true);
            foreach ($availableTimes as $availableTime) {
                $date = Carbon::createFromFormat('d/m/Y', $request->date);
                // Check for day
                if (strtolower($date->englishDayOfWeek) == $availableTime['day']) {
                    // Check for times
                    $delimiter = ':';
                    $explodedFrom = explode($delimiter, $request->from);
                    $explodedTo = explode($delimiter, $request->to);
                    $explodedAvailableFrom = explode($delimiter, $availableTime['from']);
                    $explodedAvailableTo = explode($delimiter, $availableTime['to']);

                    if (Carbon::createFromTime($explodedFrom[0], $explodedFrom[1])
                            ->between(
                                Carbon::createFromTime($explodedAvailableFrom[0], $explodedAvailableFrom[1]),
                                Carbon::createFromTime($explodedAvailableTo[0], $explodedAvailableTo[1]))
                        && Carbon::createFromTime($explodedTo[0], $explodedTo[1])
                            ->between(
                                Carbon::createFromTime($explodedAvailableFrom[0], $explodedAvailableFrom[1]),
                                Carbon::createFromTime($explodedAvailableTo[0], $explodedAvailableTo[1]))
                    ) {
                        $diffInMinutes = Carbon::createFromTime($explodedFrom[0], $explodedFrom[1])
                            ->diffInMinutes(Carbon::createFromTime($explodedTo[0], $explodedTo[1]));
                        $priceInEur = $diffInMinutes / 5;
                        $buddy['price'] = $priceInEur;
                        $availableBuddies[] = $buddy;
                    }
                }
            }
        }

        return response()->json([
            'status' => 'success',
            'available_buddies_data' => $availableBuddies,
        ]);
    }

    public function getUser(Request $request, $id) {
        $user = User::find($id);

        return response()->json(
            [
                'status' => 'success',
                'user_data' => $user->toArray()
            ], 200);
    }

    public function uploadAvatar(Request $request) {
        $user = Auth::user();
        $imageQuality = 60;

        if($request->file->isValid()) {
            $avatarPath = 'storage/uploads/avatars/' . $request->file->hashName();

            Image::make($request->file)->save($avatarPath, $imageQuality);

            if ($user->avatar_path != '/storage/uploads/avatars/default.png') {
                File::delete(public_path() . $user->avatar_path);
            }
        }
        else {
            return response()->json(
                [
                    'status' => 'error',
                    'errors' => ['file' => ['Bestand kon niet worden geüpload.']],
                ], 422);
        }

        $user->avatar_path = '/' . $avatarPath;
        $user->save();

        return response()->json(
            [
                'status' => 'success',
            ], 200);
    }

    public function changeInfo(Request $request) {
        $user = Auth::user();

        $v = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => [
                'required', 'string', 'email', 'max:255',
                Rule::unique('users')->ignore($user),
            ],
        ]);

        if ($v->fails())  {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors(),
            ], 422);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return response()->json(['status' => 'success'], 200);
    }

    public function changePassword(Request $request) {
        $user = Auth::user();

        Validator::extend('equal_hash', function ($attribute, $value, $parameters, $validator) use ($request, $user) {
            return Hash::check($request->old_password, $user->password);
        });

        $v = Validator::make($request->all(), [
            'old_password'  => 'required|string|max:255|equal_hash',
            'password'  => 'required|string|min:8|max:255|confirmed',
        ]);

        if ($v->fails())  {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors(),
            ], 422);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['status' => 'success'], 200);
    }
}

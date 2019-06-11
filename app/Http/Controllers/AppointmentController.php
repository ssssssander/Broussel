<?php

namespace App\Http\Controllers;

use App\User;
use App\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AppointmentController extends Controller
{
    public function makeAppointment(Request $request) {
        Validator::extend('divisible_by', function ($attribute, $value, $parameters, $validator) {
            return intval(explode(':', $value)[1]) % $parameters[0] === 0;
        });

        $requestValidator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'buddy_id' => 'required|integer',
            'day'  => 'required|date_format:Y-m-d',
            'time_from' => 'required|date_format:H:i|divisible_by:5',
            'time_to' => 'required|date_format:H:i|after:time_from|divisible_by:5',
        ]);

        if($requestValidator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $requestValidator->errors(),
            ], 422);
        }

        $buddy = new Appointment;
        $buddy->user_id = $request->user_id;
        $buddy->buddy_id = $request->buddy_id;
        $buddy->day =  $request->day;
        $buddy->time_from = $request->time_from;
        $buddy->time_to = $request->time_to;
        $buddy->save();

        return response()->json(['status' => 'success'], 200);
    }

    public function getAppointments(Request $request) {
        $appointments = Auth::user()->appointments->toArray();
        $appointmentsWithBuddyName = [];

        foreach ($appointments as $appointment) {
            $appointment['buddy_name'] = User::find($appointment['buddy_id'])->name;
            $appointmentsWithBuddyName[] = $appointment;
        }

        return response()->json([
            'status' => 'success',
            'appointments_data' => $appointmentsWithBuddyName,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use App\Appointment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
        $idColumnToFind = '';
        $appointments = [];
        $appointmentsWithExtra = [];

        if (Auth::user()->role == 'user') {
            $appointments = Auth::user()->appointments->toArray();
            $idColumnToFind = 'buddy_id';
        }
        if (Auth::user()->role == 'buddy') {
            $appointments = Appointment::where('buddy_id', Auth::id())->get()->toArray();
            $idColumnToFind = 'user_id';
        }

        foreach ($appointments as $appointment) {
            $user = User::find($appointment[$idColumnToFind]);
            $appointment['person_name'] = $user->name;
            $appointment['person_id'] = $user->id;
            $appointment['person_role'] = $user->role;
            $appointmentsWithExtra[] = $appointment;
        }

        return response()->json([
            'status' => 'success',
            'appointments_data' => $appointmentsWithExtra,
        ], 200);
    }

    public function getChattableBuddy(Request $request) {
        $latest = [];

        if (Auth::user()->role == 'user') {
            $latestAppointment = Auth::user()->appointments->last();

            if ($latestAppointment) {
                $latest = User::find($latestAppointment->buddy_id);
            }
        }
        if (Auth::user()->role == 'buddy') {
            $latestAppointment = Appointment::where('buddy_id', Auth::id())->get()->last();

            if ($latestAppointment) {
                $latest = User::find($latestAppointment->user_id);
            }
        }

        return response()->json([
            'status' => 'success',
            'chattable_buddies_data' => $latest,
        ], 200);
    }

    public function makeIcal(Request $request) {
        $user = Auth::user();
        $appointments = [];
        $iCalFullString =
'BEGIN:VCALENDAR
PRODID:-//Broussel//Broussel Calendar 1.0//NL
METHOD:PUBLISH
VERSION:2.0
CALSCALE:GREGORIAN
X-WR-CALNAME:Broussel agenda van ' . $user->name . '
X-WR-TIMEZONE:Europe/Brussels
X-WR-CALDESC:Broussel agenda van ' . $user->name . ' (' . $user->email . ')';

        if ($user->role == 'user') {
            $appointments = $user->appointments;
        }
        if ($user->role == 'buddy') {
            $appointments = Appointment::where('buddy_id', Auth::id())->get();
        }

        foreach ($appointments as $appointment) {
            if ($user->role == 'user') {
                $userOnWalkWith = User::find($appointment->buddy_id);
            }
            if ($user->role == 'buddy') {
                $userOnWalkWith = User::find($appointment->user_id);
            }

            $format = 'Ymd\THis';
            $start = Carbon::parse($appointment->day . ' ' . $appointment->time_from)->format($format);
            $end = Carbon::parse($appointment->day . ' ' . $appointment->time_to)->format($format);
            $now = Carbon::now()->format($format);
            $created = Carbon::parse($appointment->created_at)->format($format);
            $lastModified = Carbon::parse($appointment->updated_at)->format($format);
            $summary = 'Wandelen met ' . $userOnWalkWith->name;
            $description = $summary . ' op ' . $appointment->day . ' van ' . $appointment->time_from . ' tot ' . $appointment->time_to;

            $iCalEventString =
'
BEGIN:VEVENT
DTSTART:' . $start . '
DTEND:' . $end. '
DTSTAMP:' . $now . '
UID:' . (string)Str::uuid() . '@broussel.be
CREATED:' . $created .'
DESCRIPTION:' . $description . '
LAST-MODIFIED:' . $lastModified . '
LOCATION:Brussel
SEQUENCE:0
STATUS:CONFIRMED
SUMMARY:' . $summary . '
TRANSP:OPAQUE
END:VEVENT';
            $iCalFullString .= $iCalEventString;
        }

        $iCalFullString .= PHP_EOL . 'END:VCALENDAR';

        $putDir = 'calendars/broussel-calendar-' . $user->email . Str::random(8) . '.ics';
        $iCalUrl = url('storage/' . $putDir);
        Storage::put($putDir, $iCalFullString);

        return response()->json([
            'status' => 'success',
            'ical_url' => $iCalUrl,
        ], 200);
    }
}

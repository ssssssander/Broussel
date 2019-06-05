<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DateTimeController extends Controller
{
    public function validateDateTime(Request $request) {
        $requestValidator = Validator::make($request->all(), [
            'date' => 'required|date_format:d/m/Y',
            'from' => 'required|date_format:H:i',
            'to'  => 'required|date_format:H:i|after:from',
        ]);

        if($requestValidator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $requestValidator->errors(),
            ], 422);
        }

        return response()->json(['status' => 'success'], 200);
    }
}

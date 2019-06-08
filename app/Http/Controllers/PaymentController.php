<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PaymentCredentials;

class PaymentController extends Controller
{
    public function chargeRequest(Request $request) {
        \Stripe\Stripe::setApiKey(PaymentCredentials::STRIPE_SECRET_KEY);

        $charge = \Stripe\Charge::create([
            'amount' => $request->amount,
            'currency' => 'eur',
            'source' => $request->source,
        ]);

        return response($charge,200);
    }
}

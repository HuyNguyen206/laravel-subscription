<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentIntentController extends Controller
{
    public function store(Request $request)
    {
        $paymentIntent = app('stripe')->paymentIntents->create([
            'amount' => 10000,
            'currency' => 'usd',
            'setup_future_usage' => 'on_session',
            'metadata' => [
                'user_id' => (string) $request->user()->id
            ]
        ]);

        return view('subscriptions.lifetime-payment', compact('paymentIntent'));
    }
}

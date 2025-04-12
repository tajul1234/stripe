<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StripePaymentController extends Controller
{
    public function stripe()
    {
        return view('stripe');
    }

    public function stripePost(Request $request)
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        \Stripe\Charge::create([
            "amount" => 100 * 100, // 100 taka
            "currency" => "bdt", // or "usd"
            "source" => $request->stripeToken,
            "description" => "Payment from Laravel App",
        ]);

        return back()->with('success', 'Payment successful!');
    }
}

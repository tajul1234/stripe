<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\SetupIntent;
use App\Models\User;
use Stripe\Price;


class SubscriptionController extends Controller
{
    // This method shows the subscription page
    public function showSubscriptionPage()
{
    $user = auth()->user();

    // Set the secret API key
    Stripe::setApiKey(env('STRIPE_SECRET'));

    // Create a Setup Intent for Stripe
    $intent = SetupIntent::create();

    // Get the price object from Stripe using the price ID
    $price = Price::retrieve('price_1RCgILFVv2MKHj0o8fDXZOLP'); // Replace with your actual price ID

    // Get the unit amount (price) in the lowest currency unit (e.g., cents) and convert to dollars
    $amount = $price->unit_amount / 100;  // Assuming it's in cents

    // Pass the intent and price amount to the subscription view
    return view('subscription', ['intent' => $intent, 'price' => $amount]);
}

    // Handle the subscription logic
    public function subscribe(Request $request)
    {
        $user = auth()->user();
        $paymentMethod = $request->payment_method;

        if (!$paymentMethod) {
            return back()->with('error', 'Payment method is missing.');
        }

        $user->createOrGetStripeCustomer();
        $user->addPaymentMethod($paymentMethod);

        // Create subscription
        $subscription = $user->newSubscription('default', 'price_1RCgILFVv2MKHj0o8fDXZOLP')
                             ->create($paymentMethod);

        // Save subscription ID to session
        session(['subscription_id' => $subscription->id]);

        return redirect()->route('subscription.success');
    }

    // Subscription success page
    public function success()
{
    $user = auth()->user();
    $subscription = $user->subscription('default');

    if (!$subscription) {
        return redirect()->route('su')->with('error', 'No active subscription found.');
    }

    Stripe::setApiKey(env('STRIPE_SECRET'));
    $price = \Stripe\Price::retrieve($subscription->stripe_price);

    // get next billing date from Stripe subscription
    $nextBillingDate = \Carbon\Carbon::createFromTimestamp(
        $subscription->asStripeSubscription()->current_period_end
    )->toFormattedDateString();

    return view('subscription-success', [
        'subscription' => $subscription,
        'amount' => $price->unit_amount / 100,
        'priceCurrency' => strtoupper($price->currency),
        'nextBillingDate' => $nextBillingDate,
    ]);
}






}

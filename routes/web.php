<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AamarpayController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\StripePaymentController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');




//stripe one-to-one

Route::get('stripe', [StripePaymentController::class, 'stripe'])->name('stripe');
Route::post('stripe', [StripePaymentController::class, 'stripePost'])->name('stripe.post');



//stripe subscription payment

Route::get('/subscription', [SubscriptionController::class, 'showSubscriptionPage'])->name('su');
Route::post('/subscribe', [SubscriptionController::class, 'subscribe'])->name('subscribe');
Route::get('/subscription/success', [SubscriptionController::class, 'success'])->name('subscription.success');




//Ammarpay






Route::get('/pay', [AamarpayController::class, 'index'])->name('pay');
Route::post('/pay', [AamarpayController::class, 'makePayment'])->name('pay.now');


Route::match(['GET', 'POST'], '/payment/success', [AamarpayController::class, 'success']);
Route::match(['GET', 'POST'], '/payment/fail', [AamarpayController::class, 'fail']);
Route::match(['GET', 'POST'], '/payment/cancel', [AamarpayController::class, 'cancel']);







Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
require __DIR__.'/auth.php';

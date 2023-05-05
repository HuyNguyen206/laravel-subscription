<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('plans', [\App\Http\Controllers\Subscriptions\PlanController::class, 'index'])->name('plans.index');
    Route::get('plans/swap', [\App\Http\Controllers\Subscriptions\PlanController::class, 'showFormSwap'])->name('plans.swap');
    Route::post('plans/swap', [\App\Http\Controllers\Subscriptions\PlanController::class, 'swap'])->name('plans.swap');

    Route::get('checkout', [\App\Http\Controllers\Subscriptions\CheckoutController::class, 'checkout'])->name('checkout');
    Route::post('checkout', [\App\Http\Controllers\Subscriptions\CheckoutController::class, 'store'])->name('store');
    Route::prefix('billing')->group(function (){
        Route::get('account', [\App\Http\Controllers\Subscriptions\AccountController::class, 'index'])->name('account.index');

        Route::get('apply-coupon', [\App\Http\Controllers\Subscriptions\SubscriptionController::class, 'showApplyCouponForm'])->name('subscription.coupon');
        Route::post('apply-coupon', [\App\Http\Controllers\Subscriptions\SubscriptionController::class, 'applyCoupon'])->name('subscription.coupon');

        Route::get('subscription/update-card', [\App\Http\Controllers\Subscriptions\SubscriptionController::class, 'showUpdatePaymentMethodForm'])->name('subscription.show-update-payment-form');
        Route::post('subscription/update-card', [\App\Http\Controllers\Subscriptions\SubscriptionController::class, 'updatePaymentMethod'])->name('subscription.update-payment');
        Route::get('subscription', [\App\Http\Controllers\Subscriptions\SubscriptionController::class, 'index'])->name('subscription.index');
        Route::get('subscription/cancel', [\App\Http\Controllers\Subscriptions\SubscriptionController::class, 'showFormCancel'])->name('subscription.cancel');
        Route::post('subscription/cancel', [\App\Http\Controllers\Subscriptions\SubscriptionController::class, 'cancel'])->name('subscription.cancel');
        Route::get('subscription/resume', [\App\Http\Controllers\Subscriptions\SubscriptionController::class, 'showFormResume'])->name('subscription.resume');
        Route::post('subscription/resume', [\App\Http\Controllers\Subscriptions\SubscriptionController::class, 'resume'])->name('subscription.resume');
        Route::get('subscription/invoices', [\App\Http\Controllers\Subscriptions\SubscriptionController::class, 'getInvoices'])->name('subscription.invoices');
        Route::get('subscription/invoices/download/{invoiceId}', [\App\Http\Controllers\Subscriptions\SubscriptionController::class, 'downloadInvoice'])->name('subscription.invoices.download');

    });
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';

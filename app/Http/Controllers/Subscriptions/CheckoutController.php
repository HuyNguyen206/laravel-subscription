<?php

namespace App\Http\Controllers\Subscriptions;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Rules\CouponValid;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Laravel\Cashier\Exceptions\IncompletePayment;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware(function (Request $request, \Closure $next, string ...$guards) {
            if ($request->user()->is_lifetime || $request->user()->subscribed('default')) {
                return redirect()->route('subscription.index');
            }

            return $next($request);
        });
    }

    public function checkout(Request $request)
    {
        $plan = $request->get('plan', 'monthly');
        $price = Plan::whereSlug($plan)->value('price');

        if ($plan === 'lifetime') {
            $request->user()->createOrGetStripeCustomer();
            $paymentIntent = app('stripe')->paymentIntents->create([
                'amount' => $price * 100,
                'currency' => 'usd',
                'setup_future_usage' => 'on_session',
                'metadata' => [
                    'user_id' => (string) $request->user()->id
                ],
                'customer' => $request->user()->stripe_id
            ]);

            return view('subscriptions.lifetime-payment', ['paymentIntent' => $paymentIntent]);
        }

        return view('subscriptions.checkout', ['clientSecret' => $request->user()->createSetupIntent()->client_secret]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'plan' => ['sometimes', Rule::in(['monthly', 'yearly', 'forever'])],
            'coupon' => ['sometimes', new CouponValid()]
        ]);

        $plan = $request->get('plan', 'monthly');
        $plan = Plan::whereSlug($plan)->first();
        try {
            $request->user()->newSubscription('default', $plan->stripe_id)
                ->withCoupon($request->coupon)
                ->create($request->token);

        } catch (IncompletePayment $ex) {
            return redirect()->route('cashier.payment', [
                $ex->payment->id,
                'redirect' => route('subscription.index')
            ]);
        }

        return back();
    }
}

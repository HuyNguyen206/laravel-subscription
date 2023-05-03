<?php

namespace App\Http\Controllers\Subscriptions;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CheckoutController extends Controller
{

    public function __construct()
    {
        $this->middleware(function (Request $request, \Closure $next, string ...$guards){
            if ($request->user()->subscribed('default')) {
                return redirect()->route('subscription.index');
            }

            return $next($request);
        });
    }

    public function checkout(Request $request)
    {
        return view('subscriptions.checkout', ['clientSecret' => $request->user()->createSetupIntent()->client_secret]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'plan' => ['sometimes', Rule::in(['monthly', 'yearly', 'forever'])]
        ]);

        $plan = $request->get('plan', 'monthly');
        $plan = Plan::whereSlug($plan)->first();

        $request->user()->newSubscription('default', $plan->stripe_id)->create($request->token);

        return back();
    }
}

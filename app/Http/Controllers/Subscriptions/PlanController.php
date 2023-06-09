<?php

namespace App\Http\Controllers\Subscriptions;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Laravel\Cashier\Exceptions\IncompletePayment;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::all();
        return view('subscriptions.plans', compact('plans'));
    }

    public function showFormSwap(Request $request)
    {
        $plans = Plan::query()->where('stripe_id', '!=', $request->user()->plan->stripe_id)->get();
        return view('subscriptions.swap', compact('plans'));
    }

    public function swap(Request $request)
    {
        $request->validate([
            'plan' => ['required', 'string', Rule::exists('plans', 'slug')]
        ]);
        try {
            if ($request->plan === 'lifetime') {
                if ($request->user()->subscribed()) {
                    $request->user()->subscription()->cancel();
                }
                $payment = $request->user()->pay(
                    Plan::whereSlug('lifetime')->value('price') * 100
                );

                return view('subscriptions.lifetime-payment', ['paymentIntent' => $payment]);
            }
            $request->user()->subscription()->swap(Plan::query()->whereSlug($request->plan)->value('stripe_id'));
        } catch (IncompletePayment $ex) {
            return redirect()->route('cashier.payment', [
                $ex->payment->id,
                'redirect' => route('subscription.index')
            ]);
        }

        return redirect()->route('subscription.index');
    }
}

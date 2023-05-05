<?php

namespace App\Http\Controllers\Subscriptions;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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

        $request->user()->subscription()->swap(Plan::query()->whereSlug($request->plan)->value('stripe_id'));

        return redirect()->route('subscription.index');
    }
}

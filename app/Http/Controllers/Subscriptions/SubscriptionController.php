<?php

namespace App\Http\Controllers\Subscriptions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        return view('subscriptions.index');
    }

    public function showFormCancel()
    {
        return view('subscriptions.cancel');
    }

    public function cancel(Request $request)
    {
        $this->authorize('cancelSubscription', $subscription = $request->user()->subscription());
        $subscription->cancel();

        return redirect()->route('subscription.index');
    }

    public function showFormResume()
    {
        return view('subscriptions.resume');
    }

    public function resume(Request $request)
    {
        $this->authorize('resumeSubscription', $subscription = $request->user()->subscription());
        $subscription->resume();

        return redirect()->route('subscription.index');
    }
}

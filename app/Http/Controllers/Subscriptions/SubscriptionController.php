<?php

namespace App\Http\Controllers\Subscriptions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Cashier\Subscription;

class SubscriptionController extends Controller
{
    public function index()
    {
        return view('subscriptions.index');
    }

    public function showFormCancel(Request $request)
    {
        if (!$request->user()->can('cancelSubscription', Subscription::class)) {
            return back();
        }

        return view('subscriptions.cancel');
    }

    public function cancel(Request $request)
    {
        $this->authorize('cancelSubscription', $subscription = $request->user()->subscription());
        $subscription->cancel();

        return redirect()->route('subscription.index');
    }

    public function showFormResume(Request $request)
    {
        if (!$request->user()->can('resumeSubscription', Subscription::class)) {
            return back();
        }

        return view('subscriptions.resume');
    }

    public function resume(Request $request)
    {
        $this->authorize('resumeSubscription', $subscription = $request->user()->subscription());
        $subscription->resume();

        return redirect()->route('subscription.index');
    }

    public function getInvoices(Request $request)
    {
        return view('subscriptions.invoices', ['invoices' => $request->user()->invoices()]);
    }

    public function downloadInvoice(Request $request, string $invoiceId)
    {
        $useStripeInvoice = $request->boolean('use-stripe-invoice', false);
        if ($useStripeInvoice) {
            return redirect($request->user()->findInvoice($invoiceId)->asStripeInvoice()->invoice_pdf);
        }

        return $request->user()->downloadInvoice($invoiceId, [
            'vendor' => config('app.name'),
            'product' => 'Membership'
        ]);
    }
}

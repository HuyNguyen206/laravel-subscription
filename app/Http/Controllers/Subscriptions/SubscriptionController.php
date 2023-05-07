<?php

namespace App\Http\Controllers\Subscriptions;

use App\Http\Controllers\Controller;
use App\Rules\CouponValid;
use Illuminate\Http\Request;
use Laravel\Cashier\Subscription;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $stripeBillingPortal = $request->user()->stripe_id ? $request->user()->billingPortalUrl(route('subscription.index')) : null;
        $subscription = $request->user()->getStripeSubscription();
        $invoice = $request->user()->getStripeInvoice();
        $customer = $request->user()->getStripeCustomer();
        $coupon = $subscription->coupon();

        return view('subscriptions.index',
            compact('stripeBillingPortal', 'subscription',
                'invoice', 'customer', 'coupon'));
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

    public function showUpdatePaymentMethodForm(Request $request)
    {
        return view('subscriptions.update-card', ['clientSecret' => $request->user()->createSetupIntent()->client_secret]);
    }

    public function updatePaymentMethod(Request $request)
    {
        $request->validate([
            'token' => 'required',
        ]);

        $request->user()->updateDefaultPaymentMethod($request->token);

        return redirect()->route('subscription.index');
    }

    public function showApplyCouponForm()
    {
        return view('subscriptions.apply-coupon');
    }

    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon' => ['required', new CouponValid()]
        ]);

        $request->user()->subscription()->updateStripeSubscription([
            'coupon' => $request->coupon
        ]);

        return redirect()->route('subscription.index');
    }
}

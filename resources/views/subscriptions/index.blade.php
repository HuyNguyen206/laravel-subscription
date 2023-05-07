<x-account-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(request()->user()->subscribed())
                        <ul class="max-w-md space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400">
                            @if($subscription)
                                <li>
                                    Plan: {{$subscription->interval()}} ({{$subscription->amount()}}
                                    /{{$subscription->interval()}})
                                    <br>
                                    @if(request()->user()->subscription()->canceled())
                                        End at {{$subscription->cancelAt()}} <a class="text-blue-700"
                                                                                href="{{route('subscription.resume')}}">Resume</a>
                                    @endif
                                </li>
                            @endif
                                @if($coupon)
                                    <li>
                                        Coupon: {{$coupon->name()}} ({{$coupon->value()}} off)
                                    </li>
                                @endif
                            @if($invoice)
                                <li>
                                    Next invoice: {{$invoice->amount()}} {{$invoice->nextPaymentAttemp()}}
                                </li>
                            @endif
                                @if($customer)
                                    <li>
                                        Customer balance: {{$customer->amount()}}
                                    </li>
                                @endif
                        </ul>
                    @else
                        You don't have subscription
                    @endif

                </div>
                @isset($stripeBillingPortal)
                    <h3>
                        <a class="text-blue-700" href="{{$stripeBillingPortal}}">Stripe Billing Portal</a>
                    </h3>
                @endisset

            </div>
        </div>
    </div>
</x-account-layout>

<x-account-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    Subscriptions
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

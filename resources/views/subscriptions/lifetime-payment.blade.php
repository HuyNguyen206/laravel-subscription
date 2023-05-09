<x-account-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                   Lifetime payment
                </div>
                <form id="payment-form" data-secret="{{$paymentIntent->client_secret}}">
                    <div id="payment-element">
                        <!-- Elements will create form elements here -->
                    </div>

                    <div id="error-message" class="text-red-500 my-2">
                        <!-- Display error message to your customers here -->
                    </div>

                    <button id="submit" class="mt-4 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>

                </form>
            </div>
        </div>
    </div>
    @section('script')
        <script>
            const stripe = Stripe('{{config('cashier.stripe_key')}}');

            const options = {
                clientSecret: '{{$paymentIntent->client_secret}}',
                // Fully customizable with appearance API.
                appearance: {/*...*/},
            };

            // Set up Stripe.js and Elements to use in checkout form, passing the client secret obtained in step 3
            const elements = stripe.elements(options);

            // Create and mount the Payment Element
            const paymentElement = elements.create('payment');
            paymentElement.mount('#payment-element');

            const form = document.getElementById('payment-form');

            form.addEventListener('submit', async (event) => {
                event.preventDefault();

                const {error} = await stripe.confirmPayment({
                    //`Elements` instance that was used to create the Payment Element
                    elements,
                    confirmParams: {
                        return_url: '{{route('subscription.index')}}',
                    },
                });

                if (error) {
                    // This point will only be reached if there is an immediate error when
                    // confirming the payment. Show error to your customer (for example, payment
                    // details incomplete)
                    const messageContainer = document.querySelector('#error-message');
                    messageContainer.textContent = error.message;
                } else {
                    // Your customer will be redirected to your `return_url`. For some payment
                    // methods like iDEAL, your customer will be redirected to an intermediate
                    // site first to authorize the payment, then redirected to the `return_url`.
                }
            });
        </script>
    @endsection
</x-account-layout>



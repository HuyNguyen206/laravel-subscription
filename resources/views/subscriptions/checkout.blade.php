<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">Checkout</h2>
                    <form action="{{route('store')}}" method="post" id="card-form">
                        @csrf
                        <input type="hidden" name="plan" value="{{request('plan', 'monthly')}}">
                        <div class="mb-6">
                            <label for="base-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name
                                on card</label>
                            <input name="customer_name" id="card-holder-name" type="text" id="base-input"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>

                        <div class="mb-6">
                            <label for="base-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Card detail
                            </label>
                            <div id="card-element"></div>
                        </div>
                        <div class="mb-6">
                            <button data-secret="{{$clientSecret}}" type="submit" id="card-button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @section('script')
        <script>
            const stripe = Stripe('{{config('cashier.stripe_key')}}')

            const elements = stripe.elements()
            const cardElement = elements.create('card')
            cardElement.mount('#card-element')

            const form = document.getElementById('card-form')
            const cardButton = document.getElementById('card-button')
            const cardHoldername = document.getElementById('card-holder-name')

            form.addEventListener('submit', async  (e) => {
                e.preventDefault()
                cardButton.disabled = true

                const {setupIntent, error} = await stripe.confirmCardSetup(
                    cardButton.dataset.secret, {
                        payment_method: {
                            card: cardElement,
                            billing_details: {
                                name: cardHoldername.value
                            }
                        }
                    }
                )

                if (error) {
                    cardButton.disabled = false
                } else {
                    console.log(setupIntent)
                    let token = document.createElement('input')
                    token.setAttribute('type', 'hidden')
                    token.setAttribute('name', 'token')
                    token.setAttribute('value', setupIntent.payment_method)
                    form.appendChild(token)
                    form.submit()
                }
            })
        </script>
    @endsection
</x-app-layout>

<x-account-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    Invoices
                </div>

                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                               Date
                            </th>
                            <th scope="col" class="px-6 py-3">
                              Total
                            </th>
                            <th scope="col" class="px-6 py-3">
                              Action
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($invoices as $invoice)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-6 py-4">
                                    {{$invoice->date()->toFormattedDateString()}}
                                </td>
                               <td class="px-6 py-4">
                                   {{$invoice->total()}}
                               </td>
                                <td class="px-6 py-4">
                                    <a class="text-blue-600" href="{{route('subscription.invoices.download', ['invoiceId' => $invoice->id, 'use-stripe-invoice' => true])}}">Download</a>
                               </td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-account-layout>

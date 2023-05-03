<x-account-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                   Cancel Subscriptions
                </div>
                <form action="{{route('subscription.cancel')}}" method="post">
                    @csrf
                    <div class="mb-6">
                        <button type="submit" id="card-button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-account-layout>

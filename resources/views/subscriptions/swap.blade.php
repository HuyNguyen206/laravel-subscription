<x-account-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    Swap plan
                </div>
                <form action="{{route('plans.swap')}}" method="post">
                    @csrf
                    <div class="mb-6">
                        <label for="plans" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select
                            an option</label>
                        <select id="plans"
                                name="plan"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="">Choose a plan</option>
                            @foreach($plans as $plan)
                                <option value="{{$plan->slug}}">{{$plan->title}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-6">
                        <button type="submit" id="card-button"
                                class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Swap
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-account-layout>

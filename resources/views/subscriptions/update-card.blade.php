<x-account-layout>
    <x:card-form action="{{route('subscription.update-payment')}}">
        <div class="mb-6">
            <button data-secret="{{$clientSecret}}" type="submit" id="card-button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Update</button>
        </div>
    </x:card-form>
</x-account-layout>

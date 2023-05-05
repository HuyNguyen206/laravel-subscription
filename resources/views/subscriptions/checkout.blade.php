<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <x:card-form action="{{route('store')}}">
        <div class="mb-6">
            <input type="hidden" name="plan" value="{{request('plan', 'monthly')}}">
            <div class="mb-6">
                <label for="coupon" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Coupon</label>
                <input name="coupon" id="coupon"
                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </div>
            <button data-secret="{{$clientSecret}}" type="submit" id="card-button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
        </div>
    </x:card-form>
</x-app-layout>

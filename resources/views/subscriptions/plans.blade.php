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
                    <h2 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">Plans</h2>
                    <ul class="max-w-md space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400">
                        @foreach($plans as $plan)
                            <li>
                                <a href="{{route('checkout', ['plan' => $plan->slug])}}">{{$plan->title}}</a>
                            </li>
                        @endforeach
                    </ul>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

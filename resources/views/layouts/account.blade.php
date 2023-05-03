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
                    <div class="flex flex-wrap">
                        <div class="border-r border-gray-200 dark:border-gray-700">
                            <nav class="flex flex-col space-y-2" aria-label="Tabs" role="tablist" data-hs-tabs-vertical="true">
                                <a href="{{route('account.index')}}" class="{{\request()->routeIs('account.index') ? 'font-semibold' : ''}} hs-tab-active:border-blue-500 hs-tab-active:text-blue-600 dark:hs-tab-active:text-blue-600 py-1 pr-4 inline-flex items-center gap-2 border-r-[3px] border-transparent text-sm whitespace-nowrap text-gray-500 hover:text-blue-600 active" id="vertical-tab-with-border-item-1" data-hs-tab="#vertical-tab-with-border-1" aria-controls="vertical-tab-with-border-1" role="tab">
                                    Account
                                </a>
                                <a href="{{route('subscription.index')}}" class="{{\request()->routeIs('subscription.index') ? 'font-semibold' : ''}} hs-tab-active:border-blue-500 hs-tab-active:text-blue-600 dark:hs-tab-active:text-blue-600 py-1 pr-4 inline-flex items-center gap-2 border-r-[3px] border-transparent text-sm whitespace-nowrap text-gray-500 hover:text-blue-600 dark:hover:text-gray-300" id="vertical-tab-with-border-item-2" data-hs-tab="#vertical-tab-with-border-2" aria-controls="vertical-tab-with-border-2" role="tab">
                                    Subscription
                                </a>
                                @if(auth()->user()->subscribed())
                                    @can('cancelSubscription', auth()->user()->subscription())
                                        <a href="{{route('subscription.cancel')}}" class="{{\request()->routeIs('subscription.cancel') ? 'font-semibold' : ''}} hs-tab-active:border-blue-500 hs-tab-active:text-blue-600 dark:hs-tab-active:text-blue-600 py-1 pr-4 inline-flex items-center gap-2 border-r-[3px] border-transparent text-sm whitespace-nowrap text-gray-500 hover:text-blue-600 dark:hover:text-gray-300" id="vertical-tab-with-border-item-3" data-hs-tab="#vertical-tab-with-border-3" aria-controls="vertical-tab-with-border-3" role="tab">
                                            Cancel subscription
                                        </a>
                                    @elsecan('resumeSubscription', auth()->user()->subscription())
                                        <a href="{{route('subscription.resume')}}" class="{{\request()->routeIs('subscription.resume') ? 'font-semibold' : ''}} hs-tab-active:border-blue-500 hs-tab-active:text-blue-600 dark:hs-tab-active:text-blue-600 py-1 pr-4 inline-flex items-center gap-2 border-r-[3px] border-transparent text-sm whitespace-nowrap text-gray-500 hover:text-blue-600 dark:hover:text-gray-300" id="vertical-tab-with-border-item-3" data-hs-tab="#vertical-tab-with-border-3" aria-controls="vertical-tab-with-border-3" role="tab">
                                            Resume subscription
                                        </a>
                                    @endcan

                                @endif

                            </nav>
                        </div>

                        <div class="ml-3">
                            <div id="vertical-tab-with-border-1" role="tabpanel" aria-labelledby="vertical-tab-with-border-item-1">
                                <p class="text-gray-500 dark:text-gray-400">
                                   {{$slot}}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

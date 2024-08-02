<x-app-layout>
    <div class="p-4 grid md:grid-cols-8 gap-y-6 gap-x-6 items-start ">
        <x-card class="col-span-full md:col-span-5 bg-gradient-to-br to-sky-50/90 from-white">
            <x-slot name="body" class="h-48">
               @include('dashboard.overview')
            </x-slot>
        </x-card>

        <x-card class="col-span-full md:col-span-3 row-span-2  self-stretch ">
            <x-slot name="header">
                <div class="flex justify-between">
                    <h2>Categories</h2>
                    <div>
                        <x-select-year-month class="text-gray-500"/>
                    </div>
                </div>
            </x-slot>
            <x-slot name="body">
                <div class="overflow-x-auto -mx-4">
                    @include('dashboard.categories')
                </div>
            </x-slot>
        </x-card>

        <x-card class="col-span-full md:col-span-5">
            <x-slot name="header">
                <div class="flex justify-between">
                    <h2>Last 5 transactions</h2>
                    <div>
                        <a href="{{ route('transactions.index') }}" class="underline text-sm text-sky-600 hover:text-sky-700">Show All</a>
                    </div>
                </div>
            </x-slot>
            <x-slot name="body" class="overflow-x-auto  -mx-4 -mb-4 -mt-2 ">
                @include('dashboard.latest-transactions') 
            </x-slot>
        </x-card>
        
        <x-card class="col-span-full">
            <x-slot name="header">
                <div class="flex justify-between">
                    <h2>Monthly Budgets</h2>
                    <div>
                        <x-select-year-month class="text-gray-500"/>
                    </div>
                </div>
            </x-slot>
            <x-slot name="body" class="overflow-x-auto  -mx-4 ">
                @include('dashboard.monthly-budgets')
            </x-slot>
        </x-card>

    </div>
</x-app-layout>
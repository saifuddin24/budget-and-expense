<x-app-layout>

    <div class="max-w-6xl mx-auto sticky top-0 border-b py-4 px-6 bg-green-50 z-20 flex items-center">
        <h2 class="text-xl">Transactions</h2>
        <div class="ml-4 flex gap-4">
            <a href="{{ route('transactions.create','cash') }}" class="px-2 py-1 bg-green-600 leading-none text-white shadow rounded uppercase">Add Fund</a>
            <a href="{{ route('transactions.create','transaction') }}" class="px-2 py-1 bg-sky-600 leading-none text-white shadow rounded uppercase">Add Transaction</a>
            <a href="{{ route('categories.index', 'for-create-transaction') }}" class="px-2 py-1 bg-rose-800 leading-none text-white shadow rounded uppercase">Add Expense</a>
        </div>

        <div class="ml-auto">
            <form method="GET" action="" class="flex gap-2 items-center">

                @if(request()->has('page'))
                    <input type="hidden" name="page" value="1">
                @endif

                <div class="">
                    <select name="category-id" class="px-2  py-1 border">
                        <option value="">--ALL CATEGORY--</option>
                        @foreach ($categories as $category)
                            <option 
                                value="{{ $category->id }}"
                                {{ 
                                    request()->get('category-id') == $category->id 
                                        ? 'selected'
                                        : '' 
                                }}
                            >
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="px-3 py-1 border bg-green-600 rounded shadow text-white">
                    FILTER
                </button>
            </form>
        </div>
    </div>

    <div class="max-w-6xl mx-auto w-full bg-white z-10">


        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-900 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-200">
                    <tr>


                        <th scope="col" class="px-6 py-3">Id</th>
                        <th scope="col" class="px-6 py-3">Particular</th>
                        <th scope="col" class="px-6 py-3 text-right">Cash</th>
                        <th scope="col" class="px-6 py-3 text-right">Cash Balance</th>
                        <th scope="col" class="px-6 py-3 text-right">Bank</th>
                        <th scope="col" class="px-6 py-3 text-right">Bank Balance</th>
                        <th scope="col" class="px-6 py-3 text-right">Total Balance</th>
                       
                    </tr>
                </thead>
                <tbody>

                    @forelse ($transactions as $index => $transaction)
                        <tr class="group {{ $index%2==0 ?'bg-gray-100/40 hover:bg-gray-100':'bg-gray-50/40 hover:bg-gray-100' }}">

                            <td 
                                scope="col" 
                                class="px-6 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                            >
                                {{ $transaction->id }}
                            </td>
                            <td 
                                scope="col" 
                                class="px-6 py-3 font-medium text-gray-800 whitespace-nowrap dark:text-white"
                            >
                                <div class="text-lg">
                                    {{ $transaction->title }}
                                </div>
                                <div class="font-normal text-xs text-gray-500">
                                    {{ strtoupper($transaction->created_at->format('d M Y h:i a')) }}
                                </div>

                                @if($transaction->category)
                                    <div class="mt-4 font-normal text-xs text-gray-500">
                                        Category: {{ $transaction->category->name ?? '' }}
                                    </div>
                                @endif

                                @if($transaction->budget)
                                    <div class="mt-4 font-normal text-xs text-gray-500">
                                        <div>
                                            <span class="font-semibold">Budget: </span>
                                            {{ $transaction->budget->title ?? ''}}
                                        </div>
                                        <div>
                                            <span class="font-semibold">Amount: </span> 
                                            {{ $transaction->budget->amount ?? ''}}
                                        </div>
                                    </div>
                                @endif

                            </td>
                            
                            @php
                                $cash_amount = $transaction->cash_credit_amount - $transaction->cash_debit_amount;   
                            @endphp
                            <td 
                                scope="col" 
                                class=" px-6 py-3 text-right 
                                        font-medium text-gray-900 whitespace-nowrap 
                                        dark:text-white
                                        {{ $cash_amount < 0 ? 'text-red-500':'text-green-500' }}
                                "
                            >
                                {{ $cash_amount ?: '0' }}
                            </td>

                            <td 
                                scope="col" 
                                class="px-6 py-3 text-right font-medium text-gray-700 whitespace-nowrap dark:text-white"
                            >
                                {{ $transaction->cash_balance }}
                            </td>

                            @php
                                $bank_amount = $transaction->bank_credit_amount - $transaction->bank_debit_amount;   
                            @endphp
                            <td 
                                scope="col" 
                                class=" px-6 py-3 text-right 
                                        font-medium text-gray-900 whitespace-nowrap 
                                        dark:text-white
                                        {{ $bank_amount < 0 ? 'text-red-500':'text-green-500' }}
                                "
                            >
                                {{ $bank_amount ?: '0' }}
                            </td>
                            
                            <td 
                                scope="col" 
                                class="px-6 py-3 text-right font-medium 
                                    text-gray-700 whitespace-nowrap 
                                    dark:text-white
                                    "
                            >
                                {{ $transaction->bank_balance }}
                            </td>

                            <td 
                                scope="col" 
                                class="px-6 py-3 text-right font-medium 
                                    text-gray-900 whitespace-nowrap 
                                    dark:text-white
                                    "
                            >
                                {{ $transaction->cash_balance + $transaction->bank_balance }}
                            </td>
                        
                        </tr>
                    @empty
                        <tr>
                            <td colspan="15" class="text-center py-4 text-sm">No Transaction Found</td>
                        </tr>
                    @endforelse

                     
                     
                </tbody>
            </table>

        </div>

        <div class="px-6 py-2 sticky bottom-0 bg-pink-200/90">
            {{ $transactions->withQueryString()->onEachSide(5)->links() }}
        </div>
        
    </div>

</x-app-layout>
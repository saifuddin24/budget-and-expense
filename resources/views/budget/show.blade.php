<x-app-layout>

    
 
    <div class="max-w-6xl mx-auto  border-b py-4 px-6 bg-green-50 z-20">

        <div class="w-6/12  mx-auto">

            <div>
                <h2 class="text-xl border-b mb-2 pb-2">
                    <span>{{ ucfirst($budget->frequency) }} </span> 
                    <strong>{{ $budget->title }}</strong> 
                </h2>
                @if ($budget->frequency === 'monthly')
                    <form method="GET" action="" class="my-3">
                        <div class="flex gap-4 justify-center">
                            <div>
                                <select name='year' class="border rounded px-2 py-1">
                                    <option value="">--SELECT YEAR--</option>
                                    @foreach (range(date('Y')-2, date('Y')+2) as $year)
                                        <option value="{{ $year }}" {{ request()->get('year',date('Y')) == $year ? 'selected':'' }}>
                                            {{ $year }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <select name='month' class="border rounded px-2 py-1">
                                    <option value="">--SELECT MONTH--</option>
                                    @foreach (range(01, 12) as $month)
                                        <option value="{{ $month }}" {{ request()->get('month', date('m')) == $month ? 'selected':'' }}>
                                            {{ \Illuminate\Support\Carbon::make(date('Y') ."-".$month."-01" )->format('F') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="border px-3 py-0.5 rounded-sm text-sm bg-slate-400">SHOW</button>
                        </div>
                    </form> 
                @endif   
            </div>
    
            <table class="table-fixed w-full">
                <tr class="group {{0==0 ?'bg-gray-100/40 hover:bg-gray-100':'bg-gray-50/40 hover:bg-gray-100' }}">
                    <th class="border-b border-t border-r py-2 w-6/12 text-right px-4">Description</th>
                    <td class="border-b border-t py-2  w-6/12 text-left px-4">
                        {{ $budget->description }}
                    </td>
                </tr>

                <tr class="group {{0==0 ?'bg-gray-100/40 hover:bg-gray-100':'bg-gray-50/40 hover:bg-gray-100' }}">
                    <th class="border-b border-t border-r py-2 w-6/12 text-right px-4">Category</th>
                    <td class="border-b border-t py-2  w-6/12 text-left px-4">
                        {{ $budget->category->name ?? '' }}
                    </td>
                </tr>
                 
                <tr class="group {{1==0 ?'bg-gray-100/40 hover:bg-gray-100':'bg-gray-50/40 hover:bg-gray-100' }}">
                    <th class="border-b border-t border-r py-2 w-6/12 text-right px-4">Budget Amount</th>
                    <td class="border-b border-t py-2  w-6/12 text-right px-4">
                        {{ number_format( $budget->amount, 2 ) }}
                    </td>
                </tr>

                <tr class="group {{1==0 ?'bg-gray-100/40 hover:bg-gray-100':'bg-gray-50/40 hover:bg-gray-100' }}">
                    <th class="border-b border-t border-r py-2 w-6/12 text-right px-4">Expense</th>
                    <td class="border-b border-t py-2  w-6/12 text-right px-4 {{ $total_cash_transaction + $total_bank_transaction < 0 ? 'text-red-700':'text-green-500' }}">
                        {{ number_format( $total_cash_transaction + $total_bank_transaction, 2 ) }}
                    </td>
                </tr>
    
                <tr class="group {{0==0 ?'bg-gray-100/40 hover:bg-gray-100':'bg-gray-50/40 hover:bg-gray-100' }}">
                    <th class="border-b border-t border-r py-2 w-6/12 text-right px-4">Status</th>
                    <td class="border-b border-t py-2  w-6/12 text-right px-4">
                        {{ number_format( $budget_amount_remaining, 2 ) }}
                    </td>
                </tr>
            </table>

            <div class="mt-4 flex justify-between gap-4 w-full">
                <a href="{{ route('budgets.index') }}" class="px-2 py-1 bg-green-600 leading-none text-white shadow rounded uppercase">&larr; Budgets</a>

                <a href="{{ route( 'budgets.transactions.create', $budget->id ) }}" class="px-2 py-1 bg-rose-800 leading-none text-white shadow rounded uppercase">&plus; Add Expense</a>
            </div>
        </div>


    </div>
    <div class="max-w-6xl mx-auto sticky top-0 border-b py-4 px-6 bg-green-50 z-20 flex items-center">
        <h2 class="text-xl">
            <span>{{ ucfirst($budget->frequency) }} </span> 
            <strong>{{ $budget->title }} </strong>
            <span>
                Transactions
            </span> 
        </h2>
        

        {{-- <div class="ml-auto">
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
        </div> --}}
    </div>

    <div class="max-w-6xl mx-auto w-full bg-white z-10">


        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-900 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-200">
                    <tr>
                        <th scope="col" class="px-6 py-3">Id</th>
                        <th scope="col" class="px-6 py-3">Particular</th>
                        <th scope="col" class="px-6 py-3">Month</th>
                        <th scope="col" class="px-6 py-3 text-right">Cash Transaction</th>
                        <th scope="col" class="px-6 py-3 text-right">Bank Transaction</th>
                        <th scope="col" class="px-6 py-3 text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="text-lg">

                        <th scope="col" class="px-6 py-3"></th>
                        <th scope="col" class="px-6 py-3" colspan="2">Total Transactions</th>
                        <th scope="col" class="px-6 py-3 text-right">
                            {{ $total_cash_transaction }}
                        </th>
                        <th scope="col" class="px-6 py-3 text-right">
                            {{ $total_bank_transaction }}
                        </th>
                        <th scope="col" class="px-6 py-3 text-right">
                            {{ $total_cash_transaction + $total_bank_transaction }}
                        </th>
                       
                    </tr>

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

                            </td>

                            <td scope="col" class="px-6 py-3 font-medium text-gray-800 whitespace-nowrap dark:text-white">
                                {{ $transaction->year_month->format('F Y')  }}
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
                                    text-gray-900 whitespace-nowrap 
                                    dark:text-white
                                    "
                            >
                                {{ $cash_amount + $bank_amount }}
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
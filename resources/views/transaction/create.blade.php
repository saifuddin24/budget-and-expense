<x-app-layout>

    <div class="max-w-2xl mx-auto sticky top-0 border-b py-4 px-6 bg-green-50 z-20 ">

        @if (request()->has('cash'))
            <h2 class="text-xl border-b mb-4">Add Fund</h2>
        @elseif(request()->has('transaction'))
            <h2 class="text-xl border-b mb-4">Add Transactions</h2>
        @else
            @if(request()->route('budget') instanceof \App\Models\Budget)

                <h2 class="text-xl border-b mb-4">Add Expense for Budget <strong>{{ $budget->title }}</strong></h2>

                <div class="border-b mb-6">

                    <div class="mb-2">
                        <div class="text-gray-500 text-sm">Budget Frequenty:</div>
                        <div>{{ $budget->frequency ?? 'One Time'  }}</div>
                    </div>

                    <div class="mb-2">
                        <div class="text-gray-500 text-sm">Budget Amount:</div>
                        <div>{{ number_format($budget->amount, 2) }}</div>
                    </div>

                    <div class="mb-2">
                        <div class="text-gray-500 text-sm">Total Transaction:</div>
                        <div>
                            {{ 
                                number_format(
                                    abs($total_cash_transaction) + abs($total_bank_transaction), 2
                                ) 
                            }}
                        </div>
                    </div>
                </div>

            @elseif(isset($category))
                <h2 class="text-xl border-b mb-4"> 
                    <span>
                        Add Expense for
                    </span>
                    <strong>
                        {{ $category->name }}
                    </strong>
                </h2>
            @endif
        @endif

        <form class="block" action="{{ $store_route }}" method="POST">

            @csrf

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-2 gap-4">
            
                <div class="col-span-2 mb-2">
                    <label class="block">Particular</label>
                    <input 
                        type="text" 
                        name="title" 
                        value="{{ old('title', $transaction->title ??  ( isset($budget) ?  $budget->title .' Paid':'') ) }}"
                        class="w-full z-10 inline-flex items-center py-2.5 px-4  text-gray-800 bg-white border border-gray-300 rounded-lg focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700 dark:text-white dark:border-gray-600 text-lg"  
                    >
                </div>

                <div class="col-span-full">
                    <label class="text-center w-full block">Transaction Month</label>
                    <div class="flex gap-4 justify-center">
                        <div>
                            <select name='trx_year' class="border rounded px-2 py-1">
                                <option>--SELECT YEAR--</option>
                                @foreach (range(date('Y')-2, date('Y')+2) as $year)
                                    <option value="{{ $year }}" {{ old('trx_year',date('Y')) == $year ? 'selected':'' }}>
                                        {{ $year }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <select name='trx_month' class="border rounded px-2 py-1">
                                <option>--SELECT MONTH--</option>
                                @foreach (range(01, 12) as $month)
                                    <option value="{{ $month }}" {{ old('trx_month', date('m')) == $month ? 'selected':'' }}>
                                        {{ \Illuminate\Support\Carbon::make(date('Y') ."-".$month."-01" )->format('F') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                </div>

                @if( request()->route('budget') instanceof \App\Models\Budget )
                    @include('transaction.form.budget-expense-amount')
                @elseif (request()->has('cash'))
                    @include('transaction.form.cash-amounts')
                @elseif(request()->has('transaction'))
                    @include('transaction.form.transaction-amounts')
                @else
                    @include('transaction.form.expenses-amounts')
                @endif

                @if(isset($budgets))
                    <div class="mb-2 col-span-full">
                        <label class="text-sm">Budget (Optional)</label>
                        <select name="budget_id" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-s-lg border-e-gray-100 dark:border-e-gray-700 border-e-2 focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="">--SELECT--</option>
                            
                            @foreach ($budgets as $budget)
                                <option 
                                    value="{{ $budget->id }}" 
                                    {{ old('budget_id', $transaction->budget_id ?? '') == $budget->id }}
                                >
                                    {{ $budget->title }}
                                </option>
                            @endforeach

                        </select>
                    </div>
                @endif

                @if(isset($categories))
                    <div class="mb-2 col-span-full">
                        <label class="text-sm">Category (Optional)</label>
                        <select name="category_id" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-s-lg border-e-gray-100 dark:border-e-gray-700 border-e-2 focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="">--SELECT--</option>
                            
                            @foreach ($categories as $category)
                                <option 
                                    value="{{ $category->id }}" 
                                    {{ old('category_id', $transaction->category_id ?? '') == $category->id }}
                                >
                                    {{ $category->name }}
                                </option>
                            @endforeach

                        </select>
                    </div>
                @endif

                <div class="col-span-2 mt-6 flex items-center justify-between">
                    <a href="{{ route('transactions.index') }}" class="px-4 py-1 rounded shadow border bg-sky-300 hover:bg-sky-600 hover:text-white">Back</a>
                    <button class="px-4 py-1 rounded shadow border bg-sky-300 hover:bg-sky-600 hover:text-white">Save</button>
                </div>

            </div>
        </form>
    </div>

    <script>

        function windowOnLoad(){



            setMathExpressionCalculator( document.querySelector(  `[name="cash_amount"]` ) );
            setMathExpressionCalculator( document.querySelector(  `[name="bank_amount"]` ) );

            window.removeEventListener( 'load', windowOnLoad );
        }

        window.addEventListener('load', windowOnLoad );
        
    </script>

</x-app-layout>
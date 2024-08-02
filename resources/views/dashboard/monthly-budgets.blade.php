<table class="w-full lg:table-fixed ">
    <thead>
        <tr class="bg-gradient-to-b from-teal-50 to-teal-100 border-b">
            <th class="w-7/12 py-1.5">Title</th>
            <th class="w-3/12 py-1.5">Budget</th>
            <th class="w-2/12 py-1.5">Expense</th>
            <th class="w-2/12 py-1.5">Status</th>
        </tr>
    </thead>

    <tbody>

        @foreach ( $monthly_budgets as $budget)
            <tr class="border-b">
                <td class="py-2 px-4 w-6/12">
                    <div>
                        {{ $budget->title }}
                    </div>
                    <div class="flex gap-4">
                        <a 
                            href="{{ route('budgets.transactions.create', $budget->id ) }}"
                            class="text-sm underline text-sky-300 hover:text-teal-500"
                        >
                            Add Expense
                        </a>
                        <a 
                            href="{{ route('budgets.show', $budget->id ) }}"
                            class="text-sm underline text-sky-300 hover:text-teal-500"
                        >
                            Details
                        </a>
                    </div>

                </td>
                <td class="py-2 px-4 text-right text-sm w-2/12">
                    {{  $budget->amount }} BDT
                </td>
                <td class="py-2 px-4 text-right text-sm w-2/12">
                    {{ 
                        number_format( 
                            $budget->total_cash_expense + $budget->total_bank_expense
                            , 2
                        ) 
                    }} BDT
                </td>

                <td class="py-2 px-4 text-right text-sm w-2/12">
                    {{  number_format(
                             $budget->amount - 
                        
                            abs($budget->total_cash_expense + $budget->total_bank_expense)
                            , 2
                        ) 
                    }} BDT
                </td>

            </tr>
        @endforeach
    </tbody>
</table>
<table class="w-full ">

    <tbody>

        @foreach ( $categories as $category)
            <tr class="border-b">
                <td class="py-2 px-4 w-8/12">
                    <div>
                        {{ $category->name }}
                    </div>
                    <div class="flex gap-4">
                        <a 
                            href="{{ route('transactions.index', ['category-id' => $category->id]) }}"
                            class="text-sm underline text-sky-300 hover:text-teal-500"
                        >
                            Transactions
                        </a>
                        <a 
                            href="{{ route('categories.transactions.create', $category->id ) }}"
                            class="text-sm underline text-sky-300 hover:text-teal-500"
                        >
                            Add Expense
                        </a>
                    </div>

                </td>
                <td class="py-2 px-4 text-right w-4/12">
                    {{ 
                        number_format( 
                            $category->total_cash_expense + $category->total_bank_expense
                            , 2
                        ) 
                    }} BDT
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
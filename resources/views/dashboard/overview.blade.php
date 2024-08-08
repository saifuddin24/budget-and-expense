<div class="flex items-center">
    <div class="w-full grid grid-cols-1 md:grid-cols-3 mt-8  justify-items-center align-center">
        <div class="text-xl">
            <div class="text-gray-400">Total Revenue</div>
            <div class="text-2xl">{{ number_format( $total_revenue, 2 ) }} BDT</div>
        </div>
        <div class="text-xl">
            <div class="text-gray-400">Total Expense</div>
            <div class="text-2xl">{{ number_format( $total_expense, 2 ) }} BDT</div>
        </div>
        <div class="text-xl">
            <div class="text-gray-400">Balance</div>
            <div class="text-2xl">{{ number_format( $balance, 2 ) }} BDT</div>
        </div>
    </div>
</div>

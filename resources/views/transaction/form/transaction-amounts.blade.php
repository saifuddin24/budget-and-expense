<input type="hidden" name="mode" value="transaction">

<div class=" mb-2  col-span-full">
    <label  class="text-sm">নগদ টাকা</label>
    <div class="flex">
        <select readonly name="cash_trx_type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-s-lg border-e-gray-100 dark:border-e-gray-700 border-e-2 focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option value="">--SELECT TYPE--</option>
            <option value="credit">নগদ টাকা জমা</option>
            <option value="debit">নগদ টাকা খরচ</option>
        </select>
        <input 
            type="number" 
            name="cash_amount" 
            id="states-button"
            min="0"
            value="{{ old('cash_amount', 0) }}"
            class="flex-grow z-10 items-center py-2.5 px-4 text-lg text-gray-800 bg-white border border-gray-300 rounded-e-lg focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700 dark:text-white dark:border-gray-600"  
        >        
    </div>
</div>

<div class="mb-2 col-span-full">
    <label class="text-sm">ব্যাংক</label>
    <div class="flex">

        <select readonly name="bank_trx_type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-s-lg border-e-gray-100 dark:border-e-gray-700 border-e-2 focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option value="">--SELECT TYPE--</option>
            <option value="credit">ব্যাংকে জমা</option>
            <option value="debit">ব্যাংক থেকে উত্তোলন</option>
        </select>
        <input 
            type="number" 
            name="bank_amount" 
            id="states-button" 
            min="0"
            value="{{ old('bank_amount', 0) }}"
            class="flex-grow z-10 items-center py-2.5 px-4 text-lg text-gray-800 bg-white border border-gray-300 rounded-e-lg focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700 dark:text-white dark:border-gray-600" type="button"
        >
    </div>
</div>
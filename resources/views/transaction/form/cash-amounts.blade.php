<input type="hidden" name="mode" value="cash-add">

<div class="flex mb-2">
    <select name="cash_trx_type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-s-lg border-e-gray-100 dark:border-e-gray-700 border-e-2 focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
        <option value="credit" selected>টাকার পরিমান</option>
    </select>
    <input 
        type="number" 
        name="cash_amount" 
        id="states-button" 
        min="0"
        value="{{ old('cash_amount', 0) }}"
        class="flex-grow z-10 inline-flex items-center py-2.5 px-4 text-sm  text-gray-800 bg-white border border-gray-300 rounded-e-lg focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700 dark:text-white dark:border-gray-600" 
    >        
</div>

<div class="border rounded mb-2 flex items-center px-4 bg-gray-50">
    <label>
        <input 
            type="checkbox" 
            name="bank_withdrawal"
            value="{{ old('bank_withdrawal', '') == 'on' ? 'checked':'' }}"
        >
        <span class="text-gray-500">ব্যাংক থেকে উত্তোলন করা হয়েছে</span>
    </label>
</div>
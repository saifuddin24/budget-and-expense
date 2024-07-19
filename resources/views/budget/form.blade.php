
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

    <div class="mb-2 col-span-full">
        <label class="text-sm">Frequency  </label>
        <select name="frequency" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-s-lg border-e-gray-100 dark:border-e-gray-700 border-e-2 focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option value="">--ONE TIME--</option>
            
            @foreach ($frequencies as $frequency => $title)
                <option value="{{ $frequency }}" {{ old('frequency', $budget->frequency ?? '') == $frequency ? 'selected':'' }} >
                    {{ $title }}
                </option>
            @endforeach

        </select>
    </div>

    <div class="col-span-2 mb-2">
        <label class="block">Title</label>
        <input 
            type="text" 
            name="title" 
            value="{{ old('title', $budget->title ??  '' ) }}"
            class="w-full z-10 inline-flex items-center py-2.5 px-4 text-gray-800 bg-white border border-gray-300 rounded-lg focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700 dark:text-white dark:border-gray-600 text-lg"  
        >
    </div> 

    <div class="col-span-2 mb-2">
        <label class="block">Amount</label>
        <input 
            type="number" 
            name="amount" 
            value="{{ old('amount', $budget->amount ??  '' ) }}"
            class="w-full z-10 inline-flex items-center py-2  px-4 text-gray-800 bg-white border border-gray-300 rounded-lg focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700 dark:text-white dark:border-gray-600 "  
        >
    </div>
        
    <div class="mb-2 col-span-full">
        <label class="text-sm">Category (Optional)</label>
        <select name="category_id" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-s-lg border-e-gray-100 dark:border-e-gray-700 border-e-2 focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option value="">--SELECT--</option>
            
            @foreach ($categories as $category)
                <option 
                    value="{{ $category->id }}" 
                    {{ old('category_id', $budget->category_id ?? '') == $category->id ? 'selected':'' }}
                >
                    {{ $category->name }}
                </option>
            @endforeach

        </select>
    </div>

    <div class="col-span-2 mt-6 flex items-center justify-between">
        <a href="{{ route('budgets.index') }}" class="px-4 py-1 rounded shadow border bg-sky-300 hover:bg-sky-600 hover:text-white">Back</a>
        <button class="px-4 py-1 rounded shadow border bg-sky-300 hover:bg-sky-600 hover:text-white">Save</button>
    </div>

</div>

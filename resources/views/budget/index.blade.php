<x-app-layout>

    <div class="max-w-6xl mx-auto sticky top-0 border-b py-4 px-6 bg-green-50 z-20 flex items-center">
        
        <h2 class="text-xl">Budgets</h2>
        
        <div class="ml-4 flex gap-4">
            <a href="{{ route('budgets.create') }}" class="px-2 py-1 bg-sky-600 leading-none text-white shadow rounded uppercase">Add Budget</a>    
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
                        <th scope="col" class="px-6 py-3">Title</th>
                        <th scope="col" class="px-6 py-3">Frequency</th>
                        <th scope="col" class="px-6 py-3 text-right">Amount</th>
                        <th scope="col" class="px-6 py-3 text-right">Show</th>
                       
                    </tr>
                </thead>
                <tbody>

                    @forelse ($budgets as $index => $budget)
                        <tr class="group {{ $index%2==0 ?'bg-gray-100/40 hover:bg-gray-100':'bg-gray-50/40 hover:bg-gray-100' }}">

                            <td 
                                scope="col" 
                                class="px-6 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                            >
                                {{ $budget->id }}
                            </td>
                            <td 
                                scope="col" 
                                class="px-6 py-3 font-medium text-gray-800 whitespace-nowrap dark:text-white"
                            >
                                <div class="text-lg">
                                    {{ $budget->title }}
                                </div>
                                <div class="font-normal text-xs text-gray-500">
                                    {{ strtoupper($budget->created_at->format('d M Y h:i a')) }}
                                </div>

                                @if($budget->category)
                                    <div class="mt-4 font-normal text-xs text-gray-500">
                                        Category: {{ $budget->category->name ?? '' }}
                                    </div>
                                @endif

                            </td>

                            <td 
                                scope="col" 
                                class=" px-6 py-3 text-right 
                                        font-medium text-gray-900 whitespace-nowrap 
                                        dark:text-white
                                "
                            >
                                {{ $budget->frequency }}
                            </td>

                            <td 
                                scope="col" 
                                class=" px-6 py-3 text-right 
                                        font-medium text-gray-900 whitespace-nowrap 
                                        dark:text-white
                                "
                            >
                                {{ $budget->amount ?: '0' }}
                            </td>
                            <td 
                                scope="col" 
                                class=" px-6 py-3 text-right 
                                        font-medium text-gray-900 whitespace-nowrap 
                                        dark:text-white
                                "
                            >
                                <a href="{{ route('budgets.edit', $budget->id) }}" class="px-2 py-1 text-white bg-green-500 hover:bg-green-700 border shadow rounded">Edit</a>
                                <a href="{{ route('budgets.show', $budget->id) }}" class="px-2 py-1 text-white bg-sky-500 hover:bg-sky-700 border shadow rounded">Show</a>
                                <form action="{{ route('budgets.destroy', $budget->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-2 py-1 text-white bg-pink-500 hover:bg-pink-700 border shadow rounded">Delete</button>
                                </form>
                                 
                            </td>
                            
                        
                        </tr>
                    @empty
                        <tr>
                            <td colspan="15" class="text-center py-4 text-sm">No Budget Found</td>
                        </tr>
                    @endforelse

                     
                     
                </tbody>
            </table>

        </div>

        <div class="px-6 py-2 sticky bottom-0 bg-pink-200/90">
            {{ $budgets->withQueryString()->onEachSide(5)->links() }}
        </div>
        
    </div>

</x-app-layout>
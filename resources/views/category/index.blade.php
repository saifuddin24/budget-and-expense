<x-app-layout>

    @if (!request()->has('for-create-transaction'))
        <div class="max-w-6xl mx-auto sticky top-0 border-b py-4 px-6 bg-green-50 z-20 flex items-center">
            <h2 class="text-xl">Categories</h2>
            
            @if(false)
                <div class="ml-4 flex gap-4">
                    <a href="" class="px-2 py-1 bg-green-600 leading-none text-white shadow rounded uppercase">Add Category</a>
                    <a href="{{ route('categories.create') }}" class="px-2 py-1 bg-rose-800 leading-none text-white shadow rounded uppercase">Add Expense</a>
                </div>
            @endif

            <div class="ml-auto"></div>
        </div>
    @endif

    <div class="max-w-6xl mx-auto w-full bg-white z-10">


        @if (request()->has('for-create-transaction'))
            <h2 class="text-lg text-center font-semibold py-3 border-b">Choose a Category for expense/transaction</h2>
            <div class="grid grid-cols-4 gap-4 my-4">
                @foreach ($categories as $index => $category)
                    <a href="{{ route('categories.transactions.create', $category->id) }}" class="py-4 px-6 border shadow rounded hover:bg-sky-200 text-xl">{{ $category->name }}</a>   
                @endforeach
            </div>
        @else
            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-900 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-200">
                        <tr>
                            <th scope="col" class="px-6 py-3 w-10">Id</th>
                            <th scope="col" class="px-6 py-3">Category Name</th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse ($categories as $index => $category)
                            <tr class="group {{ $index%2==0 ?'bg-gray-100/40 hover:bg-gray-100':'bg-gray-50/40 hover:bg-gray-100' }}">

                                <td 
                                    scope="col" 
                                    class="px-6 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                >
                                    {{ $category->id }}
                                </td>
                                <td 
                                    scope="col" 
                                    class="px-6 py-3 font-medium text-gray-800 whitespace-nowrap dark:text-white"
                                >
                                    <div class="text-lg">
                                        {{ $category->name }}
                                    </div>
                                    <div class="font-normal text-xs text-gray-500">
                                        {{ strtoupper($category->created_at->format('d M Y h:i a')) }}
                                    </div>

                                </td>
                            
                            </tr>
                        @empty
                            <tr>
                                <td colspan="15" class="text-center py-4 text-sm">No Category Found</td>
                            </tr>
                        @endforelse

                        
                        
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-2 sticky bottom-0 bg-pink-200/90">
                {{ $categories->withQueryString()->onEachSide(5)->links() }}
            </div>            
        @endif

    </div>

</x-app-layout>
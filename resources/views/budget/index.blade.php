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
                        <tr  class="group budget-row {{ $index%2==0 ?'bg-gray-100/40 hover:bg-gray-100':'bg-gray-50/40 hover:bg-gray-100' }}">

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
                                <span class="text-xl">৳</span> {{ number_format($budget->amount ?: '0', 2) }}
                            </td>
                            <td 
                                scope="col" 
                                class=" px-6 py-3 text-right 
                                        font-medium text-gray-900 whitespace-nowrap 
                                        dark:text-white
                                "
                            >
                            <div class="flex items-center gap-3">

                                <a href="{{ route('budgets.edit', $budget->id) }}" class="px-2 py-1 text-white bg-green-500 hover:bg-green-700 border shadow rounded">Edit</a>
                                <a href="{{ route('budgets.show', $budget->id) }}" class="px-2 py-1 text-white bg-sky-500 hover:bg-sky-700 border shadow rounded">Show</a>
                                <button 
                                    data-action="{{ route('budgets.destroy', $budget->id) }}" class="delete px-2 py-1.5 text-white bg-pink-500 hover:bg-pink-700 border shadow rounded">
                                    <svg width="12" height="15" fill="none" xmlns="http://www.w3.org/2000/svg" class="btn-icon">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M.857 13.333C.857 14.25 1.63 15 2.571 15H9.43c.942 0 1.714-.75 1.714-1.667v-10H.857v10ZM12 .833H9L8.143 0H3.857L3 .833H0V2.5h12V.833Z" fill="currentColor"></path>
                                    </svg>
                                </button>
                            </div>
                                
                                
                                {{-- <form onclick="return confirm('Are you sure?')" action="{{ route('budgets.destroy', $budget->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-2 py-1 text-white bg-pink-500 hover:bg-pink-700 border shadow rounded">Delete</button>
                                </form> --}}
                                 
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
    
    <div class="fixed inset-0 bg-gray-400/40 z-50 hidden" id="delete-modal">
        <div class="w-96 h-screen mx-auto overflow-y-auto  ">
            <div class="w-full h-full flex items-center">
                
                <div class="bg-white w-full rounded relative">
                    <div class="border-b px-4 py-2 flex ">
                        <h2>Delete Budget</h2>

                        <button class="h-6 w-6 leading-none text-3xl  text-red-500 hover:text-red-800 absolute right-1 remove_btn" >
                            <svg xmlns="http://www.w3.org/2000/svg" class="" viewBox="0 0 24 24"  >
                                <circle fill="currentColor" stroke="#DDDDDD" stroke-width="2" cx="12" cy="12" r="10"></circle>
                                <polygon fill="#FFFFFF" stroke="#FFFFFF" stroke-width="3" points="7,7 17,17"></polygon>
                                <polygon fill="#FFFFFF" stroke="#FFFFFF" stroke-width="3" points="7,17 17,7"></polygon>
                            </svg>
                        </button>
                    </div>
                    <div class="p-4">
                        <form action="" method="POST" class="inline delete-form">
                            @csrf
                            @method('DELETE')
                            <div>
                                <label for="delete-key">Type the word 'DELETE' to delete</label>
                                <input required type="text" id="delete-key" name="delete-key" value="" class="border rounded w-full px-3 py-1 outline-1 focus:outline-sky-600">
                            </div>
                            <div class="w-full mt-4  flex justify-between items-center">
                                <button class="px-2 py-1 rounded-sm shadow  leading-none border bg-red-400 border-red-500 hover:bg-red-600 hover:text-red-50">
                                    Delete
                                </button>

                                <button type="button" class="px-2 py-1 rounded-sm shadow  leading-none border bg-red-50 border-red-500 hover:bg-red-400 remove_btn">
                                    Cancel
                                </button>
                                
                            </div>
                            
                        </form>
                    </div>
                </div>
            
            </div>
        </div>
    </div>

    <script>
        "use_strict";


        const tableRows = document.getElementsByClassName("budget-row");
        const modal = document.getElementById("delete-modal");
        const closeButton = modal.getElementsByClassName('remove_btn');
        const form = modal.querySelector('form.delete-form');
        let currentRow = null;
        let currentButton = null;


        function handleDeleteButtonClick(){
            form.reset();
            form.action = this.dataset.action;
            currentButton = this;
            modal.classList.remove('hidden');
        }

        function handleModalCloseClick(e){
            e.preventDefault();
            e.stopPropagation();
            modal.classList.add('hidden');
            form.reset();
        }

        async function handleDeleteFormSubmit(e){
            e.preventDefault( );
            e.stopPropagation( );

            let currentRow = currentButton.parentElement;
            while( currentRow && currentRow.tagName != 'TR' ) {
                currentRow = currentRow.parentElement;
            }

            if( currentRow ) {
                
                const formData = new FormData(this);
                
                try {
                    
                    await axios.post( this.action, formData );
                    currentRow.remove( );
                    modal.classList.add( 'hidden' );
                    currentButton.removeEventListener( 'click', handleDeleteButtonClick );
                    form.reset();

                } catch(e) { }
            }

        }

        form.addEventListener( 'submit', handleDeleteFormSubmit );

        Object.values(closeButton).map(function(btn){
            btn.addEventListener( 'click', handleModalCloseClick );
        });

        Object.values(tableRows).map(function(row, rowIndex){
            const deleteButton = row.querySelector( '.delete' );
            deleteButton.addEventListener( 'click',  handleDeleteButtonClick );
        })


    </script>

</x-app-layout>
<x-app-layout>
    <div class="p-4 grid md:grid-cols-8 gap-y-6 gap-x-6 items-start ">
        <x-card class="col-span-full md:col-span-5 bg-gradient-to-br to-sky-50/90 from-white">
            <x-slot name="body" class="h-48">
                <div class="flex justify-between mt-2">
                    <h2>Overview</h2>
                    <div>
                        <x-select-year-month id="overview-months" selected='' :year-months="$year_months" />
                    </div>
                </div>

                <div id="overview-container"></div>
            </x-slot>
        </x-card>

        <x-card class="col-span-full md:col-span-3 row-span-2  self-stretch ">
            <x-slot name="header">
                <div class="flex justify-between">
                    <h2>Categories</h2>
                    <div>
                        <x-select-year-month class="text-gray-500" id="categories-months"  :year-months="$year_months"/>
                    </div>
                </div>
            </x-slot>
            <x-slot name="body">
                <div class="overflow-x-auto -mx-4" id="categories"></div>
            </x-slot>
        </x-card>

        <x-card class="col-span-full md:col-span-5">
            <x-slot name="header">
                <div class="flex justify-between">
                    <h2>Last 5 transactions</h2>
                    <div>
                        <a 
                            href="{{ route('transactions.index') }}" 
                            class="underline text-sm text-sky-600 hover:text-sky-700"
                        >Show All
                        </a>
                    </div>
                </div>
            </x-slot>
            <x-slot name="body" class="overflow-x-auto  -mx-4 -mb-4 -mt-2" id="latest-transactions">
                @include('dashboard.latest-transactions') 
            </x-slot>
        </x-card>
        
        <x-card class="col-span-full">
            <x-slot name="header">
                <div class="flex justify-between">
                    <h2>Monthly Budgets</h2>
                    <div>
                        <x-select-year-month class="text-gray-500" id="budget-months"  :year-months="$year_months"/>
                    </div>
                </div>
            </x-slot>
            <x-slot name="body" class="overflow-x-auto  -mx-4">
                <div id="budget-container"></div>
            </x-slot>
        </x-card>

    </div>

    <slot name="script">

        <script>
             
             
            function init( url, options ){

                const categories_months = options.getMonthInput();

                async function load( params ){
                    const container = options.getContainer();
                    const categoriesData = (await axios.get( url, { params })).data;
                    container.innerHTML = categoriesData;
                }

                load({ year_month: categories_months.value});
                
                categories_months.addEventListener( 'change', function(){
                    load({ year_month: categories_months.value });
                });
            }

            window.addEventListener(
                'load', () => {
                    
                    init('/dashboard/categories',{
                        getMonthInput: () => {
                            return  document.getElementById('categories-months')
                        },
                        getContainer: () => {
                            return document.getElementById( 'categories' )
                        }
                    });

                    init('/dashboard/budgets',{
                        getMonthInput: () => {
                            return  document.getElementById('budget-months')
                        },
                        getContainer: () => {
                            return document.getElementById( 'budget-container' )
                        }
                    });
                   
                    init('/dashboard/overview',{
                        getMonthInput: () => {
                            return  document.getElementById('overview-months')
                        },
                        getContainer: () => {
                            return document.getElementById( 'overview-container' )
                        }
                    });


                }
            );
            

        </script>

    </slot>

</x-app-layout>
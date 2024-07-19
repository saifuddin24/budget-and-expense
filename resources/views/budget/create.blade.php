<x-app-layout>

    <div class="max-w-2xl mx-auto sticky top-0 border-b py-4 px-6 bg-green-50 z-20 ">

 
        <h2 class="text-xl border-b mb-4">Add a Budget</h2>
        
        <form class="block" action="{{ route('budgets.store') }}" method="POST">

            @csrf
            @include('budget.form')

        </form>
    </div>
</x-app-layout>
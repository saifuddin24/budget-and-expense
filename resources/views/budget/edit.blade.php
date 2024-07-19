<x-app-layout>

    <div class="max-w-2xl mx-auto sticky top-0 border-b py-4 px-6 bg-green-50 z-20 ">

 
        <h2 class="text-xl border-b mb-4">Edit {{ $budget->title }}</h2>
        
        <form class="block" action="{{ route('budgets.update', $budget->id) }}" method="POST">
            @csrf
            @method('PUT')
            @include('budget.form')
        </form>

    </div>
</x-app-layout>
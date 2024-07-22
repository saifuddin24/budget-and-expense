<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Budget and expences</title>
    @vite(['resources/css/app.css'])
</head>
<body>
    <div class="border">
        <div class="fixed top-0 bottom-0 left-0 shadow-lg z-50 border-r bg-white w-60">

            <div>
                <h2 class="text-center font-bold text-orange-600 text-xl py-5">Budget & Expense</h2>
            </div>
            <ul class="border">
                <li class="border-b">
                    <a href="{{ route('budgets.index') }}" 
                        class="py-3 px-4 block text-sm
                         {{ request()->routeIs('budgets.*')? '!bg-sky-600 text-white':'hover:bg-gray-200' }}
                        "
                    >Budgets</a>
                </li>
                <li>
                    <a href="{{ route('transactions.index') }}" 
                        class="py-3 px-4 block text-sm
                            {{ request()->routeIs('transactions.*')? '!bg-sky-600 text-white':'hover:bg-gray-200' }}"    
                        "
                    >Transactions</a>
                </li>
            </ul>
        </div>
        <main class="ml-60 z-40">
            {{ $slot }}
        </main>
    </div>
    @vite(['resources/js/app.js'])
</body>
</html>
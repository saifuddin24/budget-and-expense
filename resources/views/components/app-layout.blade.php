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
    <div class="text-gray-800">
        <div class="hidden md:block fixed top-0 bottom-0 left-0 shadow-lg z-50 border-r bg-white w-60 overflow-y-auto">

            <div>
                <h2 class="text-center font-bold text-orange-600 text-xl py-5">Budget & Expense</h2>
            </div>

            <ul class="border">
                @foreach ($_nav_menus as $nav_menu) 
                
                    <li class="border-b">
                        <a href="{{ $nav_menu->url }}" 
                            class="py-3 px-4 block text-sm
                                {{ $nav_menu->active ? '!bg-sky-600 text-white':'hover:bg-gray-200' }}
                            "
                        >{{ $nav_menu->title }}</a>
                    </li>

                @endforeach
                
            </ul>
        </div>
        <main class="md:ml-60 z-40 min-h-screen">
            {{ $slot }}
        </main>
    </div>
    @vite(['resources/js/app.js']);
    
    {{ $script ?? '' }}  
</body>
</html>
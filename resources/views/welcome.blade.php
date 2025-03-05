<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Event Manager</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="flex flex-col items-center justify-center min-h-screen text-gray-800 bg-gray-100 dark:bg-gray-900 dark:text-gray-200">
    <div class="flex justify-center mb-6">
        <img src="{{ asset('image/eventbrite-svgrepo-com.svg') }}" alt="Logo" class="w-20 h-20">
    </div>


    <header
        class="flex items-center justify-between w-full max-w-6xl px-6 py-4 bg-white shadow-md dark:bg-gray-800 sm:px-4 md:px-8 lg:px-12">
        <h1 class="text-xl font-bold text-gray-900 dark:text-gray-100 sm:text-2xl md:text-3xl">Event Manager</h1>
        <nav class="space-x-4 sm:space-x-6 md:space-x-8">
            @auth
                <a href="{{ auth()->user()->isAdmin() ? url('/admin/dashboard') : url('/events') }}"
                    class="text-gray-700 dark:text-gray-300 hover:text-gray-500">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="text-gray-700 dark:text-gray-300 hover:text-gray-500">Entrar</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                        class="text-gray-700 dark:text-gray-300 hover:text-gray-500">Cadastrar-se</a>
                @endif
            @endauth
        </nav>
    </header>

    <main class="container p-8 mx-auto text-center sm:p-6 md:p-10 lg:p-12">
        <h2 class="mb-4 text-3xl font-semibold sm:text-4xl md:text-5xl">Organize, gerencie e participe de eventos sem
            esforço</h2>
        <p class="text-lg text-gray-600 dark:text-gray-400 sm:text-xl md:text-2xl">O Event Manager facilita a criação e
            a participação em eventos. Inscreva-se hoje e comece a gerenciar seus eventos perfeitamente.</p>
        <div class="mt-6">
            <a href="{{ route('register') }}"
                class="px-6 py-3 text-white bg-blue-600 rounded-lg shadow-md hover:bg-blue-700 sm:px-8 md:px-10">Começar</a>
        </div>
    </main>

    <footer class="w-full max-w-6xl py-4 mt-12 text-center text-gray-500 border-t dark:text-gray-400 sm:py-6 md:py-8">
        &copy; {{ date('Y') }} Event Manager. All rights reserved.
    </footer>
</body>

</html>

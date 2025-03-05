<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Event Manager')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">
    <div class="min-h-screen">
        </br>
        <header>
            <div class="container flex items-center justify-between px-6 py-4 mx-auto bg-white rounded-lg shadow-md">
                <!-- Logo -->
                <a href="{{ auth()->user() && auth()->user()->isAdmin() ? route('admin.dashboard') : route('events.list') }}"
                    class="text-2xl font-bold text-gray-800 transition duration-200 hover:text-blue-500">
                    🎟 Event Manager
                </a>

                @auth
                    <div class="flex items-center space-x-6">
                        <span class="text-lg font-medium text-gray-700">👋 Olá, {{ Auth::user()->name }}</span>

                        <!-- Botão Editar Perfil -->
                        <a href="{{ route('profile.edit') }}"
                            class="px-4 py-2 text-sm text-white transition duration-200 bg-blue-500 rounded-lg hover:bg-blue-700">
                            ⚙️ Editar Perfil
                        </a>

                        <!-- Botão Logout -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="px-4 py-2 text-sm text-white transition duration-200 bg-red-500 rounded-lg hover:bg-red-700">
                                🚪 Sair
                            </button>
                        </form>
                    </div>
                @endauth
            </div>
        </header>

        <!-- Feedback Visual -->
        <div class="container mx-auto mt-4">
            @if (session('success'))
                <div id="success-alert" class="p-4 mb-4 text-green-800 bg-green-200 border border-green-400 rounded">
                    ✅ {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div id="error-alert" class="p-4 mb-4 text-red-800 bg-red-200 border border-red-400 rounded">
                    ❌ {{ session('error') }}
                </div>
            @endif
        </div>

        <!-- Conteúdo da Página -->
        <main class="container px-4 py-6 mx-auto">
            @yield('content')
        </main>
    </div>

    <script>
        // Remove alertas automaticamente após 3 segundos
        setTimeout(() => {
            document.getElementById('success-alert')?.classList.add('opacity-0');
            document.getElementById('error-alert')?.classList.add('opacity-0');
        }, 3000);
    </script>
</body>

</html>

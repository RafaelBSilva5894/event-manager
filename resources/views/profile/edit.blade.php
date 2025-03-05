@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="w-full max-w-lg p-8 bg-white border rounded-lg shadow-lg">
            <h1 class="mb-6 text-3xl font-bold text-center">✏️ Alterar Cadastro</h1>

            <!-- Mensagem de Sucesso -->
            @if (session('success'))
                <div class="px-4 py-2 mb-4 text-white bg-green-500 border border-green-600 rounded">
                    ✅ {{ session('success') }}
                </div>
            @endif

            <!-- Mensagem de Erro -->
            @if ($errors->any())
                <div class="px-4 py-2 mb-4 text-white bg-red-500 border border-red-600 rounded">
                    ❌ Houve um erro ao atualizar. Verifique os campos abaixo.
                </div>
            @endif

            <form action="{{ route('profile.update') }}" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')

                <!-- Nome -->
                <div>
                    <label class="block mb-1 font-semibold text-gray-700">👤 Nome</label>
                    <input type="text" name="name" value="{{ auth()->user()->name }}"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-300" required>
                </div>

                <!-- Email -->
                <div>
                    <label class="block mb-1 font-semibold text-gray-700">📧 Email</label>
                    <input type="email" name="email" value="{{ auth()->user()->email }}"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-300" required>
                </div>

                <!-- Nova Senha -->
                <div>
                    <label class="block mb-1 font-semibold text-gray-700">🔑 Nova Senha (Opcional)</label>
                    <input type="password" name="password" placeholder="Digite uma nova senha (mínimo 6 caracteres)"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-300">
                </div>

                <!-- Botões -->
                <div class="flex justify-between mt-4">
                    <!-- Lógica para verificar a role do usuário -->
                    @php
                        $redirectRoute =
                            auth()->user()->role === 'admin' ? route('admin.dashboard') : route('events.list');
                    @endphp

                    <a href="{{ $redirectRoute }}" class="px-4 py-2 text-gray-700 border rounded-lg hover:bg-gray-200">
                        ⬅️ Voltar
                    </a>

                    <button type="submit"
                        class="px-6 py-2 text-white transition duration-200 bg-blue-500 rounded-lg hover:bg-blue-700">
                        ✅ Atualizar Cadastro
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

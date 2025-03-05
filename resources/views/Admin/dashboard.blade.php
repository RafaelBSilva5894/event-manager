@extends('layouts.app')

@section('content')
    <div class="container px-4 py-12 mx-auto">
        <div class="flex flex-col items-center">
            <h1 class="mb-6 text-4xl font-bold text-gray-800">📊 Painel do Administrador</h1>

            <p class="mb-8 text-lg text-gray-600">
                Bem-vindo ao painel de administração! Gerencie os eventos de forma rápida e eficiente.
            </p>

            <div class="flex justify-center gap-2 px-4 py-3 text-sm text-center">
                <!-- Botão Gerenciar Eventos -->
                <a href="{{ route('admin.events.index') }}"
                    class="flex items-center px-6 py-3 text-lg font-semibold text-white transition duration-200 bg-blue-500 rounded-lg shadow-md hover:bg-blue-500">
                    📅 Gerenciar Eventos
                </a>
            </div>
        </div>
    </div>
@endsection

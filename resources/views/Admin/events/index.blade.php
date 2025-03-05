@extends('layouts.app')

@section('content')
    <div class="container px-4 py-8 mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold">📅 Gerenciar Eventos</h1>

            <!-- Botão Criar Novo Evento -->
            <a href="{{ route('admin.events.create') }}"
                class="px-3 py-2 text-white transition duration-200 bg-green-500 rounded-md hover:bg-green-700">
                ➕ Criar Novo Evento
            </a>
        </div>

        <!-- Mensagens de Sucesso e Erro -->
        @if (session('success'))
            <div class="p-4 mb-4 text-green-800 bg-green-200 border border-green-400 rounded">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="p-4 mb-4 text-red-800 bg-red-200 border border-red-400 rounded">
                ❌ {{ session('error') }}
            </div>
        @endif

        <!-- Tabela de Eventos -->
        <div class="overflow-x-auto bg-white border rounded-lg shadow-lg">
            <table class="w-full text-left border border-gray-300 rounded-lg">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 border">📌 Título</th>
                        <th class="px-6 py-3 border">📅 Início</th>
                        <th class="px-6 py-3 border">📅 Término</th>
                        <th class="px-6 py-3 border">📍 Local</th>
                        <th class="px-6 py-3 text-center border">👥 Inscrições</th>
                        <th class="px-6 py-3 text-center border">⚙️ Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($events as $event)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-3 border">{{ $event->title }}</td>
                            <td class="px-6 py-3 border">
                                {{ \Carbon\Carbon::parse($event->start_time)->format('d/m/Y - H:i') }}
                            </td>
                            <td class="px-6 py-3 border">
                                {{ \Carbon\Carbon::parse($event->end_time)->format('d/m/Y - H:i') }}
                            </td>
                            <td class="px-6 py-3 border">{{ $event->location }}</td>

                            <!-- Número de Inscrições -->
                            <td class="px-6 py-3 text-center border">
                                <a href="{{ route('admin.events.registrations', $event->id) }}"
                                    class="px-3 py-1 text-white bg-purple-500 rounded-lg hover:bg-purple-700">
                                    👥 {{ $event->registrations->count() }} inscritos
                                </a>
                            </td>

                            <!-- Ações -->
                            <td class="flex justify-center gap-2 px-4 py-3 text-sm text-center">
                                <!-- Botão Editar -->
                                <a href="{{ route('admin.events.edit', $event) }}"
                                    class="px-3 py-1 text-white transition duration-200 bg-blue-500 rounded-lg hover:bg-blue-700">
                                    ✏️ Editar
                                </a>

                                <!-- Formulário para Excluir -->
                                <form action="{{ route('admin.events.destroy', $event) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-3 py-1 text-white transition duration-200 bg-red-500 rounded-lg hover:bg-red-700">
                                        🗑️ Excluir
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

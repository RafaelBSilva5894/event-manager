@extends('layouts.app')

@section('content')
    <div class="container max-w-2xl px-4 py-12 mx-auto">
        <h1 class="mb-6 text-3xl font-bold text-center text-gray-800">✏️ Editar Evento</h1>

        <!-- Exibir mensagens de sucesso e erro -->
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

        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
            <form action="{{ route('admin.events.update', $event) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Título -->
                <label class="block mb-2 font-semibold text-gray-700">Título do Evento:</label>
                <input type="text" name="title" value="{{ $event->title }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200" required>

                <!-- Descrição -->
                <label class="block mt-4 mb-2 font-semibold text-gray-700">Descrição:</label>
                <textarea name="description" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200"
                    rows="4">{{ $event->description }}</textarea>

                <!-- Data e Hora -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block mt-4 mb-2 font-semibold text-gray-700">📅 Data de Início:</label>
                        <input type="datetime-local" name="start_time"
                            value="{{ \Carbon\Carbon::parse($event->start_time)->format('Y-m-d\TH:i') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200"
                            required>
                    </div>

                    <div>
                        <label class="block mt-4 mb-2 font-semibold text-gray-700">📅 Data de Término:</label>
                        <input type="datetime-local" name="end_time"
                            value="{{ \Carbon\Carbon::parse($event->end_time)->format('Y-m-d\TH:i') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200"
                            required>
                    </div>
                </div>

                <!-- Localização -->
                <label class="block mt-4 mb-2 font-semibold text-gray-700">📍 Localização:</label>
                <input type="text" name="location" value="{{ $event->location }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200" required>

                <!-- Capacidade Máxima -->
                <label class="block mt-4 mb-2 font-semibold text-gray-700">👥 Capacidade Máxima:</label>
                <input type="number" name="capacity" value="{{ $event->capacity }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200" required>

                <!-- Status -->
                <label class="block mt-4 mb-2 font-semibold text-gray-700">📌 Status:</label>
                <select name="status"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200" required>
                    <option value="open" @if ($event->status == 'open') selected @endif>Aberto</option>
                    <option value="closed" @if ($event->status == 'closed') selected @endif>Fechado</option>
                    <option value="canceled" @if ($event->status == 'canceled') selected @endif>Cancelado</option>
                </select>

                <!-- Botões de ação -->
                <div class="flex justify-between mt-6">
                    <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('events.list') }}"
                        class="px-6 py-2 text-gray-700 transition duration-200 bg-gray-200 rounded-lg hover:bg-gray-300">
                        🔙 Voltar
                    </a>

                    <button type="submit"
                        class="px-6 py-2 text-white transition duration-200 bg-blue-500 rounded-lg hover:bg-blue-700">
                        💾 Atualizar Evento
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

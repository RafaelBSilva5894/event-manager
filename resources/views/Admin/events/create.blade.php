@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <h1 class="mb-4 text-2xl font-bold">Criar Novo Evento</h1>

        <form action="{{ route('admin.events.store') }}" method="POST">
            @csrf

            <label class="block mb-2">Título:</label>
            <input type="text" name="title" class="w-full px-2 py-1 border" required>

            <label class="block mt-4 mb-2">Descrição:</label>
            <textarea name="description" class="w-full px-2 py-1 border"></textarea>

            <label class="block mt-4 mb-2">Data de Início:</label>
            <input type="datetime-local" name="start_time" class="w-full px-2 py-1 border" required>

            <label class="block mt-4 mb-2">Data de Término:</label>
            <input type="datetime-local" name="end_time" class="w-full px-2 py-1 border" required>

            <label class="block mt-4 mb-2">Localização:</label>
            <input type="text" name="location" class="w-full px-2 py-1 border" required>

            <label class="block mt-4 mb-2">Capacidade Máxima:</label>
            <input type="number" name="capacity" class="w-full px-2 py-1 border" required>

            <label class="block mt-4 mb-2">Status:</label>
            <select name="status" class="w-full px-2 py-1 border" required>
                <option value="open">Aberto</option>
                <option value="closed">Fechado</option>
                <option value="canceled">Cancelado</option>
            </select>

            <button type="submit" class="px-4 py-2 mt-4 text-white bg-green-500 rounded">
                Criar Evento
            </button>
        </form>
    </div>
@endsection

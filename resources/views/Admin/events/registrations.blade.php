@extends('layouts.app')

@section('content')
    <div class="container px-4 py-8 mx-auto">
        <h1 class="text-3xl font-bold text-center">📋 Inscrições para "{{ $event->title }}"</h1>

        <div class="flex justify-between my-6">
            <a href="{{ route('admin.events.index') }}" class="px-4 py-2 text-white bg-gray-500 rounded-lg hover:bg-gray-700">
                🔙 Voltar para Gerenciar Eventos
            </a>
        </div>

        @if ($event->registrations->isEmpty())
            <p class="text-lg text-center text-gray-500">Nenhum participante inscrito neste evento.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left border border-gray-300 rounded-lg shadow-lg">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-3 border">👤 Nome</th>
                            <th class="px-4 py-3 border">📧 Email</th>
                            <th class="px-4 py-3 border">📅 Data de Inscrição</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($event->registrations as $registration)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 border">{{ $registration->user->name }}</td>
                                <td class="px-4 py-3 border">{{ $registration->user->email }}</td>
                                <td class="px-4 py-3 border">
                                    {{ \Carbon\Carbon::parse($registration->created_at)->format('d/m/Y - H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection

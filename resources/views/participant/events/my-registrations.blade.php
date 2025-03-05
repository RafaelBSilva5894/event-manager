@extends('layouts.app')

@section('content')
    <div class="container px-4 py-8 mx-auto">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-3xl font-bold">🎟 Minhas Inscrições</h1>

            <!-- Botão para visualizar todos os eventos -->
            <a href="{{ route('events.list') }}"
                class="px-3 py-2 text-sm text-white transition duration-200 bg-blue-500 rounded-lg hover:bg-blue-700">
                🔄 Ver Eventos Disponíveis
            </a>
        </div>

        <!-- Mensagens de Sucesso e Erro -->
        @if (session()->has('success'))
            <div class="p-4 mb-4 text-green-800 bg-green-200 border border-green-400 rounded">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="p-4 mb-4 text-red-800 bg-red-200 border border-red-400 rounded">
                ❌ {{ session('error') }}
            </div>
        @endif

        @if ($registrations->isEmpty())
            <p class="text-lg text-center text-gray-500">
                Você ainda não está inscrito em nenhum evento.
                <a href="{{ route('events.list') }}" class="text-blue-500 underline">Ver eventos disponíveis</a>
            </p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left border border-gray-300 rounded-lg shadow-lg">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-3 border">Título</th>
                            <th class="px-4 py-3 border">📅 Início</th>
                            <th class="px-4 py-3 border">📅 Término</th>
                            <th class="px-4 py-3 border">📍 Local</th>
                            <th class="px-4 py-3 text-center border">🛑 Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($registrations as $registration)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 border">{{ $registration->event->title }}</td>
                                <td class="px-4 py-3 border">
                                    {{ \Carbon\Carbon::parse($registration->event->start_time)->format('d/m/Y - H:i') }}
                                </td>
                                <td class="px-4 py-3 border">
                                    {{ \Carbon\Carbon::parse($registration->event->end_time)->format('d/m/Y - H:i') }}
                                </td>
                                <td class="px-4 py-3 border">{{ $registration->event->location }}</td>
                                <td class="px-4 py-3 text-center border">
                                    @if ($registration->event->status === 'canceled')
                                        <span class="px-3 py-1 text-white bg-gray-500 rounded-lg">
                                            🚨 Evento Cancelado
                                        </span>
                                    @else
                                        <!-- Botão para abrir modal de descrição -->
                                        <button onclick="openModal('{{ $registration->event->id }}')"
                                            class="px-3 py-1 text-white transition duration-200 bg-yellow-500 rounded-lg hover:bg-yellow-700">
                                            📜 Ver Descrição
                                        </button>

                                        <!-- Botão para cancelar inscrição (Abre o Modal) -->
                                        <button onclick="confirmCancel('{{ $registration->event->id }}')"
                                            class="px-3 py-1 text-white transition duration-200 bg-red-500 rounded-lg hover:bg-red-700">
                                            ❌ Cancelar Inscrição
                                        </button>

                                        <!-- Modal de Confirmação -->
                                        <div id="confirm-modal-{{ $registration->event->id }}"
                                            class="fixed inset-0 flex items-center justify-center hidden bg-black bg-opacity-50">
                                            <div class="relative w-full max-w-md p-6 bg-white rounded-lg shadow-lg">
                                                <h2 class="text-lg font-bold text-center">Confirmar Cancelamento</h2>
                                                <p class="mt-4 text-center text-gray-700">
                                                    Tem certeza de que deseja cancelar sua inscrição no evento
                                                    <strong>{{ $registration->event->title }}</strong>?
                                                </p>

                                                <div class="flex justify-center mt-6 space-x-4">
                                                    <!-- Botão de Confirmação -->
                                                    <form
                                                        action="{{ route('events.unregister', $registration->event_id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="px-4 py-2 text-white bg-red-500 rounded hover:bg-red-700">
                                                            Sim, Cancelar
                                                        </button>
                                                    </form>

                                                    <!-- Botão de Fechar -->
                                                    <button onclick="closeConfirmModal('{{ $registration->event->id }}')"
                                                        class="px-4 py-2 text-gray-700 bg-gray-300 rounded hover:bg-gray-500">
                                                        Não, Voltar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                            </tr>

                            <!-- Modal de Descrição -->
                            <div id="modal-{{ $registration->event->id }}"
                                class="fixed inset-0 flex items-center justify-center hidden bg-black bg-opacity-50">
                                <div class="relative w-full max-w-md p-6 bg-white rounded-lg shadow-lg">
                                    <h2 class="text-lg font-bold text-center">{{ $registration->event->title }}</h2>
                                    <p class="mt-4 text-center text-gray-700">{{ $registration->event->description }}</p>

                                    <div class="flex justify-center mt-6">
                                        <button onclick="closeModal('{{ $registration->event->id }}')"
                                            class="px-4 py-2 text-white bg-red-500 rounded hover:bg-red-700">
                                            Fechar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <!-- Scripts para abrir e fechar o modal -->
    <script>
        function openModal(eventId) {
            document.getElementById('modal-' + eventId).classList.remove('hidden');
        }

        function closeModal(eventId) {
            document.getElementById('modal-' + eventId).classList.add('hidden');
        }

        function confirmCancel(eventId) {
            document.getElementById('confirm-modal-' + eventId).classList.remove('hidden');
        }

        function closeConfirmModal(eventId) {
            document.getElementById('confirm-modal-' + eventId).classList.add('hidden');
        }
    </script>
@endsection

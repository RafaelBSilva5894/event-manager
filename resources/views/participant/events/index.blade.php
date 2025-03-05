@extends('layouts.app')

@section('content')
    <div class="container px-4 py-8 mx-auto">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-3xl font-bold">🎟 Eventos Disponíveis</h1>

            <a href="{{ route('events.myRegistrations') }}"
                class="px-3 py-2 text-sm text-white transition duration-200 bg-purple-500 rounded-lg hover:bg-purple-700">
                🎟 Meus Eventos
            </a>
        </div>

        <!-- Lista de Eventos -->
        <div class="grid gap-6 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($events as $event)
                @if (now() < \Carbon\Carbon::parse($event->end_time))
                    {{-- Apenas exibe eventos que ainda não expiraram --}}
                    <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-lg">
                        <h2 class="mb-2 text-xl font-semibold">{{ $event->title }}</h2>

                        <p class="text-gray-700"><strong>📅 Início:</strong>
                            {{ \Carbon\Carbon::parse($event->start_time)->format('d/m/Y - H:i') }}</p>
                        <p class="text-gray-700"><strong>📅 Término:</strong>
                            {{ \Carbon\Carbon::parse($event->end_time)->format('d/m/Y - H:i') }}</p>
                        <p class="text-gray-700"><strong>📍 Local:</strong> {{ $event->location }}</p>
                        <p class="text-gray-700"><strong>👥 Vagas:</strong> {{ $event->registrations_count }} /
                            {{ $event->capacity }}</p>

                        <!-- Botões "Ver Descrição" e "Inscrever-se" -->
                        <div class="flex flex-col gap-2 mt-4">
                            <!-- Botão para abrir o modal de descrição -->
                            <button onclick="openModal('{{ $event->id }}')"
                                class="w-full py-2 text-white bg-gray-600 rounded hover:bg-gray-800">
                                📜 Ver Descrição
                            </button>

                            @if ($event->status === 'canceled')
                                <button type="button" class="w-full py-2 text-white bg-red-500 rounded cursor-default">
                                    🚨 Evento Cancelado
                                </button>
                            @elseif ($event->registrations()->where('user_id', auth()->id())->exists())
                                <button type="button" class="w-full py-2 text-white bg-green-500 rounded cursor-default">
                                    ✅ Inscrito
                                </button>
                            @elseif ($event->registrations()->count() >= $event->capacity)
                                <button type="button"
                                    class="w-full py-2 text-white bg-gray-500 rounded cursor-not-allowed">
                                    ❌ Fechado
                                </button>
                            @else
                                <form action="{{ route('events.register', $event->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="w-full py-2 text-white bg-blue-500 rounded hover:bg-blue-700">
                                        ➕ Inscrever-se
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>

                    <!-- Modal de Descrição -->
                    <div id="modal-{{ $event->id }}"
                        class="fixed inset-0 flex items-center justify-center hidden bg-black bg-opacity-50">
                        <div class="relative w-full max-w-lg p-6 bg-white rounded-lg shadow-lg">
                            <h2 class="text-xl font-bold text-center">{{ $event->title }}</h2>
                            <p class="mt-4 text-center text-gray-700">{{ $event->description }}</p>

                            <div class="flex justify-center mt-6">
                                <button onclick="closeModal('{{ $event->id }}')"
                                    class="px-4 py-2 text-white bg-red-500 rounded hover:bg-red-700">
                                    Fechar
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>

    <!-- Scripts para abrir e fechar o modal -->
    <script>
        function openModal(eventId) {
            document.getElementById('modal-' + eventId).classList.remove('hidden');
        }

        function closeModal(eventId) {
            document.getElementById('modal-' + eventId).classList.add('hidden');
        }
    </script>
@endsection

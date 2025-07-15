<x-app-layout>
    <div class="bg-slate-50 min-h-screen">
        {{-- Cabeçalho --}}
        <header class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="text-2xl font-bold text-slate-900">
                    Meus Chamados
                </h1>
            </div>
        </header>

        {{-- Conteúdo Principal --}}
        <main class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white rounded-xl shadow-sm">
                     {{-- Cabeçalho da Lista (Desktop) --}}
                    <div class="hidden md:flex px-6 py-3 border-b border-gray-200 bg-gray-50 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        <div class="flex-1">Chamado</div>
                        <div class="w-40 text-center">Status</div>
                        <div class="w-48 text-right">Ações</div>
                    </div>

                    {{-- Lista de Chamados --}}
                    <div class="p-4 md:p-0">
                        @forelse ($chamados as $chamado)
                            <div class="bg-white p-4 rounded-lg shadow-md mb-4 md:shadow-none md:rounded-none md:mb-0 md:flex md:items-center md:px-6 md:py-4 border-b border-gray-200 last:border-b-0 hover:bg-gray-50 transition-colors duration-200">
                                <div class="flex-1">
                                     <p class="font-bold text-gray-900">#{{ $chamado->id }} - {{ $chamado->titulo }}</p>
                                     <div class="text-sm text-gray-500 mt-1">Solicitante: {{ $chamado->solicitante->name ?? 'N/A' }}</div>
                                </div>
                                <div class="mt-4 md:mt-0 md:w-40 md:text-center">
                                    <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($chamado->status == \App\Enums\ChamadoStatus::ABERTO) bg-green-100 text-green-800 @endif
                                        @if($chamado->status == \App\Enums\ChamadoStatus::EM_ANDAMENTO) bg-yellow-100 text-yellow-800 @endif
                                        @if($chamado->status == \App\Enums\ChamadoStatus::RESOLVIDO) bg-blue-100 text-blue-800 @endif
                                    ">
                                        {{ $chamado->status->value }}
                                    </span>
                                </div>
                                <div class="mt-4 md:mt-0 md:w-48 md:text-right">
                                    @if($chamado->tecnico_id === Auth::id() && $chamado->status === \App\Enums\ChamadoStatus::ABERTO)
                                        <form method="POST" action="{{ route('chamados.attend', $chamado) }}" class="inline-block w-full md:w-auto">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="w-full px-4 py-2 bg-purple-600 text-white text-sm font-semibold rounded-md shadow-sm hover:bg-purple-700">
                                                Atender
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('chamados.show', $chamado) }}"
                                           class="inline-block w-full md:w-auto px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-md shadow-sm hover:bg-blue-700">Ver Detalhes</a>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="p-6 text-center text-gray-500">Nenhum chamado atribuído a você no momento.</div>
                        @endforelse
                    </div>

                    @if ($chamados->hasPages())
                        <div class="p-6 border-t border-slate-200">{{ $chamados->links() }}</div>
                    @endif
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
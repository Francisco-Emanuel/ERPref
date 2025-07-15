<x-app-layout>
    <div class="bg-slate-50 min-h-screen">
        {{-- Cabeçalho --}}
        <header class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-slate-900">
                    Gerenciar Ativos
                </h1>
                <div class="flex items-center gap-4">
                    @can('delete-ativos')
                        <a href="{{ route('ativos.trash') }}" class="inline-flex items-center gap-2 bg-white text-slate-700 font-semibold py-2 px-4 rounded-lg hover:bg-slate-100 transition-colors border border-slate-200">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                            Lixeira
                        </a>
                    @endcan
                    @can('create-ativos')
                        <a href="{{ route('ativos.create') }}" class="inline-flex items-center gap-2 bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                            Cadastrar Ativo
                        </a>
                    @endcan
                </div>
            </div>
        </header>

        {{-- Conteúdo Principal --}}
        <main class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white rounded-xl shadow-sm">
                    {{-- Cabeçalho da Lista (Desktop) --}}
                     <div class="hidden md:flex px-6 py-3 border-b border-gray-200 bg-gray-50 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        <div class="flex-1">Ativo</div>
                        <div class="w-32 text-center">Status</div>
                        <div class="w-48 text-right">Ações</div>
                    </div>
                    
                    {{-- Lista de Ativos --}}
                    <div class="p-4 md:p-0">
                         @forelse ($ativos as $ativo)
                            <div class="bg-white p-4 rounded-lg shadow-md mb-4 md:shadow-none md:rounded-none md:mb-0 md:flex md:items-center md:px-6 md:py-4 border-b border-gray-200 last:border-b-0 hover:bg-gray-50 transition-colors duration-200">
                                <div class="flex-1">
                                    <p class="font-bold text-gray-900">{{ $ativo->nome_ativo }}</p>
                                    <div class="text-sm text-gray-500 mt-1">Nº de Série: {{ $ativo->numero_serie }}</div>
                                    <div class="text-sm text-gray-500 mt-1">Responsável: {{ $ativo->responsavel->name ?? 'N/A' }}</div>
                                </div>

                                <div class="mt-4 md:mt-0 md:w-32 md:text-center">
                                    <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full {{ $ativo->status_condicao == 'Defeituoso' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                        {{ $ativo->status_condicao }}
                                    </span>
                                </div>

                                <div class="mt-4 md:mt-0 md:w-48 md:text-right">
                                     <a href="{{ route('ativos.show', $ativo) }}" class="inline-block w-full md:w-auto px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-md shadow-sm hover:bg-blue-700">Ver Detalhes</a>
                                </div>
                            </div>
                        @empty
                             <div class="p-6 text-center text-gray-500">Nenhum ativo encontrado.</div>
                        @endforelse
                    </div>

                    @if ($ativos->hasPages())
                        <div class="p-6 border-t border-slate-200">{{ $ativos->links() }}</div>
                    @endif
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
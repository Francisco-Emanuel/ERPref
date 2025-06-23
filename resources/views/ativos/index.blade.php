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
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Nome do Ativo</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Nº de Série</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Responsável</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-200">
                                @forelse ($ativos as $ativo)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap font-medium text-slate-800">{{ $ativo->nome_ativo }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-slate-500">{{ $ativo->numero_serie }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full {{ $ativo->status_condicao == 'Defeituoso' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                                {{ $ativo->status_condicao }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-slate-500">{{ $ativo->responsavel->name ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-semibold">
                                            <a href="{{ route('ativos.show', $ativo) }}" class="text-blue-600 hover:text-blue-800">Ver Detalhes</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-slate-500">Nenhum ativo encontrado.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($ativos->hasPages())
                        <div class="p-6 border-t border-slate-200">{{ $ativos->links() }}</div>
                    @endif
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
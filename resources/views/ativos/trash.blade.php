<x-app-layout>
    <div class="bg-slate-50 min-h-screen">
        {{-- Cabeçalho --}}
        <header class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">
                        Lixeira de Ativos
                    </h1>
                    <p class="mt-1 text-sm text-slate-500">Ativos que foram excluídos. Eles podem ser restaurados ou apagados permanentemente.</p>
                </div>
                <a href="{{ route('ativos.index') }}" class="inline-flex items-center gap-2 bg-white text-slate-700 font-semibold py-2 px-4 rounded-lg hover:bg-slate-100 transition-colors border border-slate-200">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                    Voltar para Ativos
                </a>
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
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Data de Exclusão</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-200">
                                @forelse ($ativos as $ativo)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap font-medium text-slate-800">{{ $ativo->nome_ativo }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-slate-500">{{ $ativo->numero_serie }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-slate-500">{{ $ativo->deleted_at->format('d/m/Y H:i') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-semibold">
                                            <div class="flex items-center justify-end gap-4">
                                                {{-- Formulário para Restaurar --}}
                                                <form action="{{ route('ativos.restore', $ativo->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="text-green-600 hover:text-green-800">Restaurar</button>
                                                </form>

                                                {{-- Formulário para Excluir Permanentemente --}}
                                                <form action="{{ route('ativos.forceDelete', $ativo->id) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir este ativo PERMANENTEMENTE? Esta ação não pode ser desfeita.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800">Excluir Perm.</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-slate-500">A lixeira está vazia.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
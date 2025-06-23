<x-app-layout>
    <div class="bg-slate-50 min-h-screen">
        {{-- Cabeçalho --}}
        <header class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="text-2xl font-bold text-slate-900">
                    Chamados Fechados
                </h1>
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
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">ID</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Título</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Solicitante</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Técnico Responsável</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Data de Fechamento</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-200">
                                @forelse ($chamados as $chamado)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-slate-500">
                                            <span class="font-semibold text-slate-600">#{{ $chamado->id }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap font-medium text-slate-800">{{ $chamado->titulo }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-slate-500">{{ $chamado->solicitante->name ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-slate-500">{{ $chamado->tecnico->name ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-slate-500">{{ $chamado->data_fechamento ? $chamado->data_fechamento->format('d/m/Y H:i') : 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-semibold">
                                            <a href="{{ route('chamados.show', $chamado) }}" class="text-blue-600 hover:text-blue-800">Ver Detalhes</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-slate-500">Nenhum chamado fechado encontrado.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($chamados->hasPages())
                        <div class="p-6 border-t border-slate-200">{{ $chamados->links() }}</div>
                    @endif
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
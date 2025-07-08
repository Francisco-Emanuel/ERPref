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
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        ID</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Título</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Status</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Solicitante</th>
                                        <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Descrição</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Ações</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-200">
                                @forelse ($chamados as $chamado)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-slate-500">
                                            <span class="font-semibold text-blue-600">#{{ $chamado->id }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap font-medium text-slate-800">
                                            {{ $chamado->titulo }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    @if($chamado->status == \App\Enums\ChamadoStatus::ABERTO) bg-green-100 text-green-800 @endif
                                                    @if($chamado->status == \App\Enums\ChamadoStatus::EM_ANDAMENTO) bg-yellow-100 text-yellow-800 @endif
                                                    @if($chamado->status == \App\Enums\ChamadoStatus::RESOLVIDO) bg-blue-100 text-blue-800 @endif
                                                ">
                                                {{ $chamado->status->value }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-slate-500">
                                            {{ $chamado->solicitante->name ?? 'N/A' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-slate-500">
                                                @php
                                                    // Limita a descrição inicial para 50 caracteres e adiciona '...' se for maior
                                                    $limitedDescription = Str::limit($chamado->descricao_inicial, 50, '...');
                                                @endphp
                                                {{ $limitedDescription ?? 'N/A' }}
                                            </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-semibold">
                                            @if($chamado->tecnico_id === Auth::id() && $chamado->status === \App\Enums\ChamadoStatus::ABERTO)
                                                <form method="POST" action="{{ route('chamados.attend', $chamado) }}"
                                                    class="inline-block">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="text-purple-600 hover:text-purple-800">
                                                        Atender
                                                    </button>
                                                </form>
                                            @else
                                                {{-- Se não for para atender, mostra o link de ver detalhes --}}
                                                <a href="{{ route('chamados.show', $chamado) }}"
                                                    class="text-indigo-600 hover:text-indigo-800">Ver Detalhes</a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-slate-500">Nenhum chamado
                                            atribuído a você no momento.</td>
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
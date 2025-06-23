<x-app-layout>
    {{-- O fundo principal da página agora é um cinza bem claro para conforto visual --}}
    <div class="bg-slate-50"> 

        {{-- Cabeçalho da Página --}}
        <header class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="text-2xl font-bold text-slate-900">
                    Dashboard
                </h1>
            </div>
        </header>

        {{-- Conteúdo Principal --}}
        <main class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="space-y-8">

                    {{-- Grade de Estatísticas --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        
                        {{-- Card de Estatística 1: Total de Ativos --}}
                        <div class="bg-white p-6 rounded-xl shadow-sm flex justify-between items-start">
                            <div>
                                <p class="text-sm font-medium text-slate-500">Total de Ativos</p>
                                <p class="text-3xl font-bold text-slate-900 mt-1">{{ $totalAtivos ?? 0 }}</p>
                            </div>
                            <div class="bg-blue-100 text-blue-600 p-3 rounded-full">
                                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-1.621-.871A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25A2.25 2.25 0 015.25 3h13.5A2.25 2.25 0 0121 5.25z" />
                                </svg>
                            </div>
                        </div>
                        
                        {{-- Card de Estatística 2: Ativos com Defeito --}}
                        <div class="bg-white p-6 rounded-xl shadow-sm flex justify-between items-start">
                            <div>
                                <p class="text-sm font-medium text-slate-500">Ativos com Defeito</p>
                                <p class="text-3xl font-bold mt-1 {{ ($ativosDefeituosos ?? 0) > 0 ? 'text-red-600' : 'text-slate-900' }}">{{ $ativosDefeituosos ?? 0 }}</p>
                            </div>
                            <div class="bg-red-100 text-red-600 p-3 rounded-full">
                                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126z" />
                                </svg>
                            </div>
                        </div>

                        {{-- Card de Estatística 3: Chamados Abertos --}}
                        <div class="bg-white p-6 rounded-xl shadow-sm flex justify-between items-start">
                            <div>
                                <p class="text-sm font-medium text-slate-500">Chamados Abertos</p>
                                <p class="text-3xl font-bold text-slate-900 mt-1">{{ $totalChamadosAbertos ?? 0 }}</p>
                            </div>
                            <div class="bg-green-100 text-green-600 p-3 rounded-full">
                                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    {{-- Card de Ações Rápidas --}}
                    <div class="bg-white p-6 rounded-xl shadow-sm">
                        <h3 class="text-lg font-semibold text-slate-900">Ações Rápidas</h3>
                        <div class="mt-4 flex flex-wrap gap-4">
                            @can('create-chamados')
                                <a href="{{ route('chamados.create') }}" class="inline-flex items-center gap-2 bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg>
                                    Abrir Novo Chamado
                                </a>
                            @endcan
                            @can('create-ativos')
                                <a href="{{ route('ativos.create') }}" class="inline-flex items-center gap-2 bg-slate-100 text-slate-700 font-semibold py-2 px-4 rounded-lg hover:bg-slate-200 transition-colors border border-slate-200">
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    Cadastrar Novo Ativo
                                </a>
                            @endcan
                        </div>
                    </div>

                    {{-- Card da Tabela de Chamados Recentes --}}
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-slate-900">Últimos Chamados Abertos</h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm">
                                {{-- Cabeçalho da tabela minimalista --}}
                                <thead class="bg-slate-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">ID</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Título</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Solicitante</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Técnico Responsável</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-slate-200">
                                    @forelse ($chamadosRecentes as $chamado)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-slate-500">
                                                <a href="{{ route('chamados.show', $chamado) }}" class="text-blue-600 font-medium hover:underline">#{{ $chamado->id }}</a>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap font-medium text-slate-800">{{ $chamado->titulo }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-slate-500">{{ $chamado->solicitante->name ?? 'N/A' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-slate-500">{{ $chamado->tecnico->name ?? 'Não atribuído' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-6 py-4 text-center text-slate-500">Nenhum chamado recente.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
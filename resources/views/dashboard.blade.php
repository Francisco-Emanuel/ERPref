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
                                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-1.621-.871A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25A2.25 2.25 0 015.25 3h13.5A2.25 2.25 0 0121 5.25z" />
                                </svg>
                            </div>
                        </div>

                        {{-- Card de Estatística 2: Ativos com Defeito --}}
                        <div class="bg-white p-6 rounded-xl shadow-sm flex justify-between items-start">
                            <div>
                                <p class="text-sm font-medium text-slate-500">Ativos com Defeito</p>
                                <p
                                    class="text-3xl font-bold mt-1 {{ ($ativosDefeituosos ?? 0) > 0 ? 'text-red-600' : 'text-slate-900' }}">
                                    {{ $ativosDefeituosos ?? 0 }}
                                </p>
                            </div>
                            <div class="bg-red-100 text-red-600 p-3 rounded-full">
                                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126z" />
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
                                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    {{-- Card de Ações Rápidas --}}
                    <div class="bg-white p-6 rounded-xl shadow-sm">
                        <h3 class="text-lg font-semibold text-slate-900">Ações Rápidas</h3>
                        <div class="mt-4 flex flex-wrap gap-4">
                            @can('create-chamados')
                                <a href="{{ route('chamados.create') }}"
                                    class="inline-flex items-center gap-2 bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                    </svg>
                                    Abrir Novo Chamado
                                </a>
                            @endcan
                            @can('create-ativos')
                                <a href="{{ route('ativos.create') }}"
                                    class="inline-flex items-center gap-2 bg-slate-100 text-slate-700 font-semibold py-2 px-4 rounded-lg hover:bg-slate-200 transition-colors border border-slate-200">
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Cadastrar Novo Ativo
                                </a>
                            @endcan
                        </div>
                    </div>

                    {{-- Container Principal da Seção --}}
                    <div class="bg-white rounded-xl shadow-sm">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-bold text-gray-900">Últimos Chamados Abertos</h3>
                        </div>

                        {{-- Cabeçalho da Lista (Visível apenas em Desktop) --}}
                        <div
                            class="hidden md:flex px-6 py-3 border-b border-gray-200 bg-gray-50 text-xs font-semibold text-gray-600 uppercase">
                            <div class="flex-1">Chamado</div>
                            <div class="w-40 text-center">Status</div>
                            <div class="w-48 text-right">Ações</div>
                        </div>

                        {{-- Lista de Chamados --}}
                        <div class="p-4 md:p-0">
                            @forelse ($chamadosRecentes as $chamado)
                                        {{-- Card Individual do Chamado (que vira linha no desktop) --}}
                                        <div
                                            class="bg-white p-4 rounded-lg shadow-md mb-4 md:shadow-none md:rounded-none md:mb-0 md:flex md:items-center md:px-6 md:py-4 border-b border-gray-200 last:border-b-0 hover:bg-gray-50 transition-colors duration-200">

                                            {{-- Seção Principal de Informações --}}
                                            <div class="flex-1">
                                                {{-- Título --}}
                                                <p class="font-bold text-gray-900 text-base">
                                                    {{ $chamado->titulo }}
                                                </p>

                                                {{-- Meta-informações (Solicitante e Técnico) --}}
                                                <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-sm text-gray-500 mt-2">
                                                    {{-- Solicitante --}}
                                                    <div class="flex items-center gap-1.5">
                                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor">
                                                            <path
                                                                d="M10 8a3 3 0 100-6 3 3 0 000 6zM3.465 14.493a1.23 1.23 0 00.41 1.412A9.957 9.957 0 0010 18c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a7.002 7.002 0 00-13.074.003z" />
                                                        </svg>
                                                        <span>{{ $chamado->solicitante->name ?? 'N/A' }}</span>
                                                    </div>
                                                    {{-- Técnico --}}
                                                    <div class="flex items-center gap-1.5">
                                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor">
                                                            <path fill-rule="evenodd"
                                                                d="M11.078 2.25c-.42.205-.678.638-.678 1.119v1.237c0 .425.12.83.337 1.173a5.25 5.25 0 008.535 3.418c.43-.333.604-.903.408-1.41a7.002 7.002 0 00-13.074.003 1.23 1.23 0 00.41 1.412 9.957 9.957 0 006.131 2.1c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a5.25 5.25 0 00-3.418-8.535c-.343-.217-.748-.337-1.173-.337H11.08zM10 8a3 3 0 100-6 3 3 0 000 6z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                        <span>{{ $chamado->tecnico->name ?? 'Não atribuído' }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Status do Chamado (Centralizado no desktop) --}}
                                            <div class="mt-4 md:mt-0 md:w-40 md:text-center">
                                                <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($chamado->status == \App\Enums\ChamadoStatus::ABERTO) bg-green-100 text-green-800 @endif
                                    @if($chamado->status == \App\Enums\ChamadoStatus::EM_ANDAMENTO) bg-yellow-100 text-yellow-800 @endif
                                    @if($chamado->status == \App\Enums\ChamadoStatus::RESOLVIDO) bg-blue-100 text-blue-800 @endif
                                    @if($chamado->status == \App\Enums\ChamadoStatus::FECHADO) bg-gray-200 text-gray-800 @endif
                                ">
                                                    {{ $chamado->status->value }}
                                                </span>
                                            </div>

                                            {{-- Botão de Ação (Alinhado à direita no desktop) --}}
                                            <div class="mt-4 md:mt-0 md:w-48 md:text-right">
                                                <a href="{{ route('chamados.show', $chamado) }}"
                                                    class="inline-block w-full md:w-auto px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 text-center">
                                                    Ver Detalhes
                                                </a>
                                            </div>
                                        </div>
                            @empty
                                <div class="p-6 text-center text-gray-500">
                                    Nenhum chamado recente para exibir.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

</x-app-layout>
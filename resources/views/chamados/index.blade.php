<x-app-layout>
    {{-- Fundo da página --}}
    <div class="bg-slate-50 min-h-screen">

        {{-- Cabeçalho --}}
        <header class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-slate-900">
                    Central de Chamados
                </h1>
                <div class="flex items-center gap-4">
                    <x-nav-link :href="route('chamados.closed')" :active="request()->routeIs('chamados.closed')">
                        Chamados Fechados
                    </x-nav-link>
                    @can('edit-chamados')
                        <x-nav-link :href="route('chamados.my')" :active="request()->routeIs('chamados.my')">
                            Meus Chamados
                        </x-nav-link>
                    @endcan
                    @can('create-chamados')
                        <a href="{{ route('chamados.create') }}"
                           class="inline-flex items-center gap-2 bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Abrir Novo Chamado
                        </a>
                    @endcan
                </div>
            </div>
        </header>

        {{-- Conteúdo Principal --}}
        <main class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                @if(session('success'))
                    <div class="mb-6 p-4 text-sm text-green-700 bg-green-100 rounded-xl shadow-sm">
                        {{ session('success') }}
                    </div>
                @endif
                
                {{-- Container da Lista de Chamados --}}
                <div class="bg-white rounded-xl shadow-sm">
                    {{-- Cabeçalho da Lista (Visível apenas em Desktop) --}}
                    <div class="hidden md:flex px-6 py-3 border-b border-gray-200 bg-gray-50 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        <div class="flex-1">Chamado</div>
                        <div class="w-40 text-center">Status</div>
                        <div class="w-48 text-right">Ações</div>
                    </div>

                    {{-- Lista de Chamados --}}
                    <div class="p-4 md:p-0">
                        @forelse ($chamados as $chamado)
                            {{-- Card Individual do Chamado --}}
                            <div class="bg-white p-4 rounded-lg shadow-md mb-4 md:shadow-none md:rounded-none md:mb-0 md:flex md:items-center md:px-6 md:py-4 border-b border-gray-200 last:border-b-0 hover:bg-gray-50 transition-colors duration-200">

                                {{-- Informações Principais --}}
                                <div class="flex-1">
                                    <p class="font-bold text-gray-900 text-base">
                                        #{{ $chamado->id }} - {{ $chamado->titulo }}
                                    </p>
                                    <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-sm text-gray-500 mt-2">
                                        <div class="flex items-center gap-1.5">
                                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M10 8a3 3 0 100-6 3 3 0 000 6zM3.465 14.493a1.23 1.23 0 00.41 1.412A9.957 9.957 0 0010 18c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a7.002 7.002 0 00-13.074.003z" /></svg>
                                            <span>{{ $chamado->solicitante->name ?? 'N/A' }}</span>
                                        </div>
                                        <div class="flex items-center gap-1.5">
                                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M11.078 2.25c-.42.205-.678.638-.678 1.119v1.237c0 .425.12.83.337 1.173a5.25 5.25 0 008.535 3.418c.43-.333.604-.903.408-1.41a7.002 7.002 0 00-13.074.003 1.23 1.23 0 00.41 1.412 9.957 9.957 0 006.131 2.1c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a5.25 5.25 0 00-3.418-8.535c-.343-.217-.748-.337-1.173-.337H11.08zM10 8a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" /></svg>
                                            <span>{{ $chamado->tecnico->name ?? 'Não atribuído' }}</span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Status --}}
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

                                {{-- Botão de Ação --}}
                                <div class="mt-4 md:mt-0 md:w-48 md:text-right">
                                    <a href="{{ route('chamados.show', $chamado) }}" 
                                       class="inline-block w-full md:w-auto px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 text-center">
                                        Ver Detalhes
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="p-6 text-center text-gray-500">
                                Nenhum chamado encontrado.
                            </div>
                        @endforelse
                    </div>

                    {{-- Paginação --}}
                    @if ($chamados->hasPages())
                        <div class="p-6 border-t border-slate-200">
                            {{ $chamados->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>

    {{-- Modais para atribuição --}}
    @foreach ($chamados as $chamado)
        @include('chamados.partials.modal-atribuir', ['chamado' => $chamado])
    @endforeach
</x-app-layout>
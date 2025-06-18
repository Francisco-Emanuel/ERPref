<x-app-layout>
    {{-- Botão de Editar --}}
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detalhes do Ativo: {{ $ativo->nome_ativo }}
            </h2>
            @can('edit-ativos')
                <a href="{{ route('ativos.edit', $ativo) }}">
                    <x-primary-button>Editar Ativo</x-primary-button>
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <div class="bg-white p-6 rounded-xl shadow-md">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Informações Gerais</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm">
                    <div>
                        <p class="font-semibold text-gray-500">Nº de Série</p>
                        <p>{{ $ativo->numero_serie }}</p>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-500">Tipo</p>
                        <p>{{ $ativo->tipo_ativo }}</p>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-500">Status</p>
                        <p>{{ $ativo->status_condicao }}</p>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-500">Responsável</p>
                        <p>{{ $ativo->responsavel->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-500">Setor</p>
                        <p>{{ $ativo->setor->nome ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-md">
                {{-- Botão de Registrar Novo Problema --}}
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Histórico de Problemas</h3>
                    {{-- Vamos assumir que quem pode criar chamados também pode registrar problemas --}}
                    @can('create-chamados')
                        <a href="{{ route('problemas.create', ['ativo_ti_id' => $ativo->id]) }}" class="text-sm">
                            <x-secondary-button>+ Registrar Novo Problema</x-secondary-button>
                        </a>
                    @endcan
                </div>
                <div class="space-y-4">
                    @forelse ($ativo->problemas as $problema)
                        <div class="border p-4 rounded-lg flex justify-between items-center">
                            <div>
                                <p class="text-gray-800">{{ $problema->descricao }}</p>
                                <p class="text-xs text-gray-500">Reportado por: {{ $problema->autor->name ?? 'N/A' }} em
                                    {{ $problema->created_at->format('d/m/Y') }}</p>
                            </div>
                            <div>
                                @if ($problema->chamado)
                                    <a href="{{ route('chamados.show', $problema->chamado) }}"
                                        class="text-sm font-semibold text-indigo-600 hover:underline">
                                        Ver Chamado #{{ $problema->chamado->id }}
                                    </a>
                                @else
                                    @can('create-chamados')
                                        <a href="{{ route('chamados.create', ['problema_id' => $problema->id]) }}" class="text-sm">
                                            <x-primary-button>Abrir Chamado</x-primary-button>
                                        </a>
                                    @endcan
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500">Nenhum problema registrado para este ativo.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
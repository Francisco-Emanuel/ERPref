<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ativos') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg px-6 py-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 ">
                @foreach ($ativos as $ativo)
                    <div class="bg-gray-100 text-gray-900 shadow-md rounded-xl p-6 w-full max-w-sm flex flex-col gap-4">

                        <!-- Status -->
                        <div class="flex items-center justify-between">
                            <h2 class="font-semibold text-lg">Status</h2>
                            @if ($ativo->status)
                                <span class="text-green-500 font-medium">Pronto</span>
                            @else
                                <span class="text-red-500 font-medium">Defeituoso</span>
                            @endif
                        </div>

                        <!-- Informações principais -->
                        <div class="grid grid-cols-2 gap-x-4 gap-y-2 text-sm">
                            <div>
                                <p class="font-semibold">Identificação</p>
                                <p>{{ $ativo['identificacao'] }}</p>
                            </div>
                            <div>
                                <p class="font-semibold">Tipo</p>
                                <p>{{ $ativo['tipo_ativo'] }}</p>
                            </div>
                            <div>
                                <p class="font-semibold">Setor</p>
                                <p>{{ $ativo['setor'] }}</p>
                            </div>
                            <div>
                                <p class="font-semibold">Responsável</p>
                                <p>{{ $ativo['usuario_responsavel'] }}</p>
                            </div>
                        </div>

                        <!-- Descrição -->
                        <div>
                            <p class="font-semibold text-sm mb-1">Descrição do problema</p>
                            <p class="text-sm text-gray-700">{{ $ativo['descricao_problema'] }}</p>
                        </div>

                    </div>

                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
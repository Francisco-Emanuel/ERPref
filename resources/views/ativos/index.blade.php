<x-app-layout>
    <x-slot name="header">
        <x-nav-link :href="route('Ativos.criar')" :active="request()->routeIs('Ativos.criar')">
            {{ __('Registrar Ativo') }}
        </x-nav-link>
        <x-nav-link :href="route('Ativos.hidden')" :active="request()->routeIs('Ativos.hidden')">
            {{ __('Ativos ocultos') }}
        </x-nav-link>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col items-center">
            <div class="bg-white shadow-sm sm:rounded-lg px-6 py-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 ">
                @foreach ($ativos as $ativo)
                    <div class="bg-gray-100 text-gray-900 shadow-md rounded-xl p-6 w-full max-w-sm flex flex-col gap-4">
                        <div class="flex items-center justify-between">
                            <h2 class="font-semibold text-lg">Status</h2>
                            @if ($ativo->status)
                                <span class="text-green-500 font-medium">Pronto</span>
                            @else
                                <span class="text-red-500 font-medium">Defeituoso</span>
                            @endif
                        </div>
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
                        <div>
                            <p class="font-semibold text-sm mb-1">Descrição</p>
                            <p class="text-sm text-gray-700">{{ $ativo['descricao_problema'] }}</p>
                        </div>
                        <div>
                            <a  href="{{ route('Ativos.edit', $ativo->id) }}" class="w-full md:w-auto px-6 py-2.5 bg-blue-700 text-white text-sm font-medium rounded-lg hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 transition">Editar</a>
                        </div>
                    </div>
                @endforeach
            </div>
            {{ $ativos->links() }}
        </div>
    </div>
</x-app-layout>
{{-- resources/views/ativos/trash.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mr-5">
            Lixeira de Ativos
        </h2>
        <x-nav-link :href="route('ativos.index')" :active="request()->routeIs('ativos.index')">
            Voltar para Ativos Visíveis
        </x-nav-link>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg p-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($ativos as $ativo)
                    <div class="bg-red-50 border border-red-200 text-gray-900 shadow-md rounded-xl p-6 w-full max-w-sm flex flex-col gap-4">
                        <div class="flex items-center justify-between">
                            <h2 class="font-semibold text-lg">{{ $ativo->nome_ativo }}</h2>
                        </div>
                        <div class="grid grid-cols-2 gap-x-4 gap-y-2 text-sm">
                            <div>
                                <p class="font-semibold">Nº de Série</p>
                                <p>{{ $ativo->numero_serie }}</p>
                            </div>
                             <div>
                                <p class="font-semibold">Responsável</p>
                                <p>{{ $ativo->responsavel->name ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="mt-auto pt-4">
                            <form action="{{ route('ativos.restore', $ativo->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="w-full text-center block px-6 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700">
                                    Restaurar Ativo
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="col-span-full text-center text-gray-500">A lixeira está vazia.</p>
                @endforelse
            </div>
            <div class="mt-6">
                {{ $ativos->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
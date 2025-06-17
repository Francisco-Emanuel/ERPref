<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Ativo: {{ $ativo->nome_ativo }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('ativos.update', $ativo) }}">
                        @method('PUT')
                        {{-- Inclui o formulário reutilizável, passando a variável $ativo --}}
                        @include('ativos._form', ['ativo' => $ativo])
                    </form>

                    <div class="mt-6 border-t pt-6">
                        <form method="POST" action="{{ route('ativos.destroy', $ativo) }}" onsubmit="return confirm('Tem certeza que deseja mover este ativo para a lixeira?');">
                            @csrf
                            @method('DELETE')
                            <x-danger-button>
                                Mover para Lixeira
                            </x-danger-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
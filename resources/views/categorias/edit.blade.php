<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Categoria: {{ $categoria->nome_amigavel }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    {{-- Formulário de atualização --}}
                    <form method="POST" action="{{ route('categorias.update', $categoria) }}">
                        @method('PUT')
                        {{-- Incluindo o formulário reutilizável que criamos --}}
                        @include('categorias._form', ['categoria' => $categoria])
                    </form>

                    {{-- Seção de exclusão --}}
                    <div class="mt-6 border-t pt-6">
                         <h3 class="text-lg font-semibold text-red-700 mb-2">Excluir Categoria</h3>
                         <p class="text-sm text-gray-600 mb-4">Uma vez excluída, a categoria não pode ser recuperada. A exclusão só será permitida se não houver chamados associados a esta categoria.</p>
                        <form method="POST" action="{{ route('categorias.destroy', $categoria) }}" onsubmit="return confirm('Tem certeza que deseja excluir esta categoria? Esta ação não pode ser desfeita.');">
                            @csrf
                            @method('DELETE')
                            <x-danger-button>
                                Excluir Categoria Permanentemente
                            </x-danger-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
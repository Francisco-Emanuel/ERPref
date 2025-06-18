{{-- resources/views/setores/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Setor: {{ $setor->nome }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    {{-- Formulário de atualização --}}
                    <form method="POST" action="{{ route('setores.update', $setor) }}">
                        @method('PUT')
                        @include('setores._form', ['setor' => $setor])
                    </form>

                    {{-- Formulário de exclusão --}}
                    <div class="mt-6 border-t pt-6">
                         <h3 class="text-lg font-semibold text-red-700 mb-2">Excluir Setor</h3>
                         <p class="text-sm text-gray-600 mb-4">Uma vez excluído, o setor não pode ser recuperado. A exclusão só será permitida se não houver usuários ou ativos associados a este setor.</p>
                        <form method="POST" action="{{ route('setores.destroy', $setor) }}" onsubmit="return confirm('Tem certeza ABSOLUTA que deseja excluir este setor?');">
                            @csrf
                            @method('DELETE')
                            <x-danger-button>
                                Excluir Setor Permanentemente
                            </x-danger-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
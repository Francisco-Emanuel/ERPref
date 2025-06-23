<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Abrir Novo Chamado
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <form method="POST" action="{{ route('chamados.store') }}">
                        @csrf
                        
                        {{-- SEÇÃO 1: INFORMAÇÕES ESSENCIAIS (OBRIGATÓRIAS) --}}
                        <div class="space-y-6">
                            <div>
                                <x-input-label for="titulo" value="Título do Chamado (Ex: Computador não liga)" />
                                <x-text-input id="titulo" name="titulo" type="text" class="mt-1 block w-full" :value="old('titulo')" required autofocus />
                                <x-input-error :messages="$errors->get('titulo')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="descricao_problema" value="Descreva o problema ou solicitação em detalhes" />
                                <textarea id="descricao_problema" name="descricao_problema" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" rows="5" required>{{ old('descricao_problema') }}</textarea>
                                <x-input-error :messages="$errors->get('descricao_problema')" class="mt-2" />
                            </div>
                        </div>

                        {{-- SEÇÃO 2: DETALHES ADICIONAIS (OPCIONAIS) --}}
                        <div class="mt-6 border-t pt-6">
                            <h3 class="text-lg font-medium text-gray-900">Detalhes Adicionais (Opcional)</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                                
                                <div>
                                    <x-input-label for="ativo_id" value="Equipamento Relacionado" />
                                    <select id="ativo_id" name="ativo_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
                                        <option value="">Nenhum / Não se aplica</option>
                                        @foreach($ativos as $ativo)
                                            <option value="{{ $ativo->id }}" @selected(old('ativo_id') == $ativo->id)>
                                                {{ $ativo->nome_ativo }} (Nº Série: {{ $ativo->numero_serie }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('ativo_id')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="categoria_id" value="Categoria" />
                                    <select id="categoria_id" name="categoria_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
                                        <option value="">Não definido</option>
                                        @foreach($categorias as $categoria)
                                            <option value="{{ $categoria->id }}" @selected(old('categoria_id') == $categoria->id)>
                                                {{ $categoria->nome_amigavel }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('categoria_id')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="prioridade" value="Prioridade" />
                                    <select id="prioridade" name="prioridade" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
                                        <option value="Baixa" @selected(old('prioridade', 'Baixa') == 'Baixa')>Baixa</option>
                                        <option value="Média" @selected(old('prioridade', 'Média') == 'Média')>Média</option>
                                        <option value="Alta" @selected(old('prioridade', 'Alta') == 'Alta')>Alta</option>
                                        <option value="Urgente" @selected(old('prioridade', 'Urgente') == 'Urgente')>Urgente</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('prioridade')" class="mt-2" />
                                </div>

                                

                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <x-primary-button>Abrir Chamado</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
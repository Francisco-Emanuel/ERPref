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
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <x-input-label for="titulo" value="Título do Chamado (Ex: Computador não liga, Impressora com erro)" />
                                <x-text-input id="titulo" name="titulo" type="text" class="mt-1 block w-full" :value="old('titulo')" required autofocus />
                            </div>
                            
                             <div>
                                <x-input-label for="ativo_ti_id" value="Qual equipamento está com problema?" />
                                <select id="ativo_ti_id" name="ativo_ti_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
                                    <option value="">Selecione um ativo</option>
                                    @foreach($ativos as $ativo)
                                        <option value="{{ $ativo->id }}" @selected(old('ativo_ti_id') == $ativo->id)>
                                            {{ $ativo->nome_ativo }} (Nº Série: {{ $ativo->numero_serie }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <x-input-label for="prioridade" value="Prioridade" />
                                <select id="prioridade" name="prioridade" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
                                    <option value="Baixa" @selected(old('prioridade') == 'Baixa')>Baixa</option>
                                    <option value="Média" @selected(old('prioridade') == 'Média')>Média</option>
                                    <option value="Alta" @selected(old('prioridade') == 'Alta')>Alta</option>
                                    <option value="Urgente" @selected(old('prioridade') == 'Urgente')>Urgente</option>
                                </select>
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="descricao_problema" value="Descreva o problema em detalhes" />
                                <textarea id="descricao_problema" name="descricao_problema" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" rows="5" required>{{ old('descricao_problema') }}</textarea>
                            </div>

                            <div class="md:col-span-2 border-t pt-6">
                                <h3 class="font-semibold text-gray-700">Atribuição (Opcional)</h3>
                            </div>
                           
                            <div>
                                <x-input-label for="categoria_id" value="Categoria" />
                                <select id="categoria_id" name="categoria_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
                                     @foreach($categorias as $categoria)
                                        <option value="{{ $categoria->id }}" @selected(old('categoria_id') == $categoria->id)>{{ $categoria->nome_amigavel }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <x-input-label for="tecnico_id" value="Atribuir a um Técnico" />
                                <select id="tecnico_id" name="tecnico_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
                                    <option value="">Não atribuir agora</option>
                                    @foreach($tecnicos as $tecnico)
                                        <option value="{{ $tecnico->id }}" @selected(old('tecnico_id') == $tecnico->id)>{{ $tecnico->name }}</option>
                                    @endforeach
                                </select>
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
<div>

    @csrf
    <div class="space-y-8 divide-y divide-slate-200">
        <div>
            <h3 class="text-lg font-semibold text-slate-900">Informações do Chamado</h3>
            <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">

                <input type="hidden" name="solicitante_id" value="{{ Auth::id() }}">

                {{-- Campo de Local --}}
                <div class="sm:col-span-3">
                    <x-input-label for="local" value="Local do Atendimento" />
                    <div class="mt-1">
                        <x-text-input id="local" name="local" type="text" class="block w-full" :value="old('local')"
                            required autofocus />
                    </div>
                    <x-input-error :messages="$errors->get('local')" class="mt-2" />
                </div>

                {{-- Campo de Departamento (apenas para exibição) --}}
                <div class="sm:col-span-3">
                    <x-input-label value="Departamento do Solicitante" />
                    <div class="mt-1">
                        <select id="departamento" name="departamento_id"
                            class="block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                            required>
                            <option value="">Selecione um departamento</option>
                            @foreach($departamentos as $departamento)
                                <option value="{{ $departamento->id }}"
                                    @selected(old('departamento_id') == $departamento->id)>
                                    {{ $departamento->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>


                <div class="sm:col-span-6">
                    <x-input-label for="titulo" value="Título do Chamado" />
                    <div class="mt-1">
                        <x-text-input id="titulo" name="titulo" type="text" class="block w-full" :value="old('titulo')"
                            required autofocus />
                    </div>
                </div>

                <div class="sm:col-span-6">
                    <x-input-label for="descricao_problema" value="Descreva o problema" />
                    <div class="mt-1">
                        <textarea id="descricao_problema" name="descricao_problema" rows="5"
                            class="block w-full rounded-md border-slate-300 shadow-sm"
                            required>{{ old('descricao_problema') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- Seção 2: Detalhes Adicionais --}}
        <div class="pt-8">
            <h3 class="text-lg font-semibold text-slate-900">Detalhes Adicionais</h3>
            <p class="mt-1 text-sm text-slate-500">Se aplicável, vincule o chamado a um equipamento, categoria ou defina
                uma prioridade.</p>

            <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">

                <div class="sm:col-span-3">
                    <x-input-label for="categoria_id" value="Categoria (Opcional)" />
                    <div class="mt-1">
                        <select id="categoria_id" name="categoria_id"
                            class="block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            <option value="">Não definido</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}" @selected(old('categoria_id') == $categoria->id)>
                                    {{ $categoria->nome_amigavel }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <x-input-error :messages="$errors->get('categoria_id')" class="mt-2" />
                </div>

                <div class="sm:col-span-3">
                    <x-input-label for="prioridade" value="Prioridade" />
                    <div class="mt-1">
                        <select id="prioridade" name="prioridade"
                            class="block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                            required>
                            <option value="Baixa" @selected(old('prioridade', 'Baixa') == 'Baixa')>Baixa</option>
                            <option value="Média" @selected(old('prioridade', 'Média') == 'Média')>Média</option>
                            <option value="Alta" @selected(old('prioridade', 'Alta') == 'Alta')>Alta</option>
                            <option value="Urgente" @selected(old('prioridade', 'Urgente') == 'Urgente')>Urgente</option>
                        </select>
                    </div>
                    <x-input-error :messages="$errors->get('prioridade')" class="mt-2" />
                </div>
            </div>
        </div>
    </div>

    <div class="pt-5 mt-5 border-t border-slate-200">
        <div class="flex justify-end gap-3">
            <a href="{{ route('chamados.index') }}"
                class="rounded-md border border-slate-300 bg-white py-2 px-4 text-sm font-medium text-slate-700 hover:bg-slate-50">Cancelar</a>
            <button type="submit"
                class="inline-flex justify-center rounded-md border border-transparent bg-blue-600 py-2 px-4 text-sm font-semibold text-white shadow-sm hover:bg-blue-700">
                Abrir Chamado
            </button>
        </div>
    </div>
</div>
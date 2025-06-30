<div x-data="{
    selectedUserId: '{{ old('solicitante_id', Auth::id()) }}',
    localAtendimento: '{{ old('local', Auth::user()->local ?? Auth::user()->departamento->nome ?? '') }}',
    departamentoAtendimento: '{{ old('departamento', Auth::user()->departamento->nome ?? 'Não definido') }}',

    fetchUserDetails() {
        if (!this.selectedUserId) return;
        
        fetch(`/api/user-details/${this.selectedUserId}`)
            .then(response => response.json())
            .then(data => {
                this.localAtendimento = data.local_padrao;
                this.departamentoAtendimento = data.departamento_nome;
            });
    }
}" x-init="fetchUserDetails()">

    @csrf
    <div class="space-y-8 divide-y divide-slate-200">
        <div>
            <h3 class="text-lg font-semibold text-slate-900">Informações do Chamado</h3>
            <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">

                {{-- Campo para selecionar o Solicitante (só aparece para técnicos/admins) --}}
                @if(Auth::user()->hasAnyRole(['Admin', 'Supervisor', 'Técnico de TI']))
                    <div class="sm:col-span-6">
                        <x-input-label for="solicitante_id" value="Abrir Chamado em Nome de:" />
                        <div class="mt-1">
                            {{-- O @change chama nossa função JS sempre que o valor mudar --}}
                            <select id="solicitante_id" name="solicitante_id" x-model="selectedUserId"
                                @change="fetchUserDetails()" class="block w-full rounded-md border-slate-300 shadow-sm">
                                @foreach($solicitantes as $solicitante)
                                    <option value="{{ $solicitante->id }}">
                                        {{ $solicitante->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @else
                    {{-- Para usuários normais, o ID é enviado em um campo escondido --}}
                    <input type="hidden" name="solicitante_id" value="{{ Auth::id() }}">
                @endif

                {{-- Campo de Local agora é preenchido dinamicamente --}}
                <div class="sm:col-span-3">
                    <x-input-label for="local" value="Local do Atendimento" />
                    <div class="mt-1">
                        {{-- O x-model:value liga o valor do campo à nossa variável JS --}}
                        <x-text-input id="local" name="local" type="text" class="block w-full"
                            x-model="localAtendimento" required />
                    </div>
                </div>

                {{-- Campo de departamento (apenas para exibição) --}}
                <div class="sm:col-span-3">
                    <x-input-label value="departamento do Solicitante" />
                    <div class="mt-1">
                        {{-- Este campo está desabilitado e apenas mostra o departamento buscado --}}
                        <p x-text="departamentoAtendimento"
                            class="block w-full px-3 py-2 bg-slate-100 border border-slate-300 rounded-md shadow-sm text-slate-600">
                        </p>
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
                    <x-input-label for="ativo_id" value="Equipamento Relacionado (Opcional)" />
                    <div class="mt-1">
                        <select id="ativo_id" name="ativo_id"
                            class="block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            <option value="">Nenhum / Não se aplica</option>
                            @foreach($ativos as $ativo)
                                <option value="{{ $ativo->id }}" @selected(old('ativo_id') == $ativo->id)>
                                    {{ $ativo->nome_ativo }} (Nº Série: {{ $ativo->numero_serie }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <x-input-error :messages="$errors->get('ativo_id')" class="mt-2" />
                </div>

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
            <a href="{{ route('chamados.index') }}" class="rounded-md border border-slate-300 bg-white py-2 px-4 text-sm font-medium text-slate-700 hover:bg-slate-50">Cancelar</a>
            <button type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-blue-600 py-2 px-4 text-sm font-semibold text-white shadow-sm hover:bg-blue-700">
                Abrir Chamado
            </button>
        </div>
    </div>
</div>
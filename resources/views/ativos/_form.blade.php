@csrf
<div class="space-y-8 divide-y divide-slate-200">
    <div>
        <h3 class="text-lg font-semibold text-slate-900">Informações do Ativo</h3>
        <p class="mt-1 text-sm text-slate-500">Preencha os detalhes para identificação e alocação do ativo de TI.</p>
        <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
            <div class="sm:col-span-3">
                <x-input-label for="nome_ativo" value="Nome do Ativo (Identificação)" />
                <div class="mt-1"><x-text-input id="nome_ativo" name="nome_ativo" type="text" class="block w-full" :value="old('nome_ativo', $ativo->nome_ativo ?? '')" required autofocus /></div>
            </div>
            <div class="sm:col-span-3">
                <x-input-label for="numero_serie" value="Número de Série" />
                <div class="mt-1"><x-text-input id="numero_serie" name="numero_serie" type="text" class="block w-full" :value="old('numero_serie', $ativo->numero_serie ?? '')" required /></div>
            </div>
            <div class="sm:col-span-3">
                <x-input-label for="tipo_ativo" value="Tipo de Ativo" />
                <div class="mt-1"><select id="tipo_ativo" name="tipo_ativo" class="block w-full rounded-md border-slate-300" required>
                    <option value="">Selecione...</option>
                    <option value="Computador" @selected(old('tipo_ativo', $ativo->tipo_ativo ?? '') == 'Computador')>Computador</option>
                    {{-- ... outras opções ... --}}
                </select></div>
            </div>
            <div class="sm:col-span-3">
                <x-input-label for="status_condicao" value="Status (Condição)" />
                <div class="mt-1"><select id="status_condicao" name="status_condicao" class="block w-full rounded-md border-slate-300" required>
                    <option value="">Selecione...</option>
                    <option value="Em uso" @selected(old('status_condicao', $ativo->status_condicao ?? '') == 'Em uso')>Em uso</option>
                    {{-- ... outras opções ... --}}
                </select></div>
            </div>
            <div class="sm:col-span-3">
                <x-input-label for="user_id" value="Responsável" />
                <div class="mt-1"><select id="user_id" name="user_id" class="block w-full rounded-md border-slate-300" required>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" @selected(old('user_id', $ativo->user_id ?? '') == $user->id)>{{ $user->name }}</option>
                    @endforeach
                </select></div>
            </div>
            <div class="sm:col-span-3">
                <x-input-label for="departamento_id" value="Departamento" /> {{-- Changed from setor_id and Setor --}}
                <div class="mt-1"><select id="departamento_id" name="departamento_id" class="block w-full rounded-md border-slate-300" required>
                    @foreach($departamentos as $departamento) {{-- Changed from $setores as $setor --}}
                        <option value="{{ $departamento->id }}" @selected(old('departamento_id', $ativo->departamento_id ?? '') == $departamento->id)>{{ $departamento->nome }}</option>
                    @endforeach
                </select></div>
            </div>
        </div>
    </div>
</div>
<div class="pt-5">
    <div class="flex justify-end">
        <a href="{{ route('ativos.index') }}" class="rounded-md border border-slate-300 bg-white py-2 px-4 text-sm font-medium text-slate-700 hover:bg-slate-50">Cancelar</a>
        <button type="submit" class="ml-3 inline-flex justify-center rounded-md border border-transparent bg-blue-600 py-2 px-4 text-sm font-semibold text-white hover:bg-blue-700">
            {{ isset($ativo) ? 'Atualizar Ativo' : 'Cadastrar Ativo' }}
        </button>
    </div>
</div>
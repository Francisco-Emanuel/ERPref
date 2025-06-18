{{-- resources/views/ativos/_form.blade.php --}}

@csrf
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <x-input-label for="nome_ativo" value="Nome do Ativo (Identificação)" />
        <x-text-input id="nome_ativo" name="nome_ativo" type="text" class="mt-1 block w-full" 
                      :value="old('nome_ativo', $ativo->nome_ativo ?? '')" required autofocus />
    </div>

    <div>
        <x-input-label for="numero_serie" value="Número de Série" />
        <x-text-input id="numero_serie" name="numero_serie" type="text" class="mt-1 block w-full" 
                      :value="old('numero_serie', $ativo->numero_serie ?? '')" required />
    </div>

    <div>
        <x-input-label for="tipo_ativo" value="Tipo de Ativo" />
        <select id="tipo_ativo" name="tipo_ativo" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
            <option value="">Selecione um tipo</option>
            <option value="Computador" @selected(old('tipo_ativo', $ativo->tipo_ativo ?? '') == 'Computador')>Computador</option>
            <option value="Notebook" @selected(old('tipo_ativo', $ativo->tipo_ativo ?? '') == 'Notebook')>Notebook</option>
            <option value="Monitor" @selected(old('tipo_ativo', $ativo->tipo_ativo ?? '') == 'Monitor')>Monitor</option>
            <option value="Impressora" @selected(old('tipo_ativo', $ativo->tipo_ativo ?? '') == 'Impressora')>Impressora</option>
            <option value="Nobreak" @selected(old('tipo_ativo', $ativo->tipo_ativo ?? '') == 'Nobreak')>Nobreak</option>
            <option value="Celular" @selected(old('tipo_ativo', $ativo->tipo_ativo ?? '') == 'Celular')>Celular</option>
            <option value="Outro" @selected(old('tipo_ativo', $ativo->tipo_ativo ?? '') == 'Outro')>Outro</option>
        </select>
        <x-input-error :messages="$errors->get('tipo_ativo')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="status_condicao" value="Status (Condição)" />
        <select id="status_condicao" name="status_condicao" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
            <option value="">Selecione uma condição</option>
            <option value="Em uso" @selected(old('status_condicao', $ativo->status_condicao ?? '') == 'Em uso')>Em uso</option>
            <option value="Em estoque" @selected(old('status_condicao', $ativo->status_condicao ?? '') == 'Em estoque')>Em estoque</option>
            <option value="Defeituoso" @selected(old('status_condicao', $ativo->status_condicao ?? '') == 'Defeituoso')>Defeituoso</option>
            <option value="Para análise" @selected(old('status_condicao', $ativo->status_condicao ?? '') == 'Para análise')>Para análise</option>
            <option value="Em manutenção" @selected(old('status_condicao', $ativo->status_condicao ?? '') == 'Em manutenção')>Em manutenção</option>
        </select>
        <x-input-error :messages="$errors->get('status_condicao')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="user_id" value="Responsável" />
        <select id="user_id" name="user_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
            @foreach($users as $user)
                <option value="{{ $user->id }}" @selected(old('user_id', $ativo->user_id ?? '') == $user->id)>
                    {{ $user->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div>
        <x-input-label for="setor_id" value="Setor" />
        <select id="setor_id" name="setor_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
            @foreach($setores as $setor)
                <option value="{{ $setor->id }}" @selected(old('setor_id', $ativo->setor_id ?? '') == $setor->id)>
                    {{ $setor->nome }}
                </option>
            @endforeach
        </select>
    </div>
</div>

<div class="mt-6 flex justify-end">
    <x-primary-button>
        {{ isset($ativo) ? 'Atualizar Ativo' : 'Cadastrar Ativo' }}
    </x-primary-button>
</div>
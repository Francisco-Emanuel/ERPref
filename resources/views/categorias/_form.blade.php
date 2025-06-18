@csrf
<div>
    <x-input-label for="nome_amigavel" value="Nome da Categoria (Ex: Problema de Hardware)" />
    <x-text-input id="nome_amigavel" name="nome_amigavel" type="text" class="mt-1 block w-full" 
                  :value="old('nome_amigavel', $categoria->nome_amigavel ?? '')" required autofocus />
    <x-input-error :messages="$errors->get('nome_amigavel')" class="mt-2" />
</div>
<div class="mt-4">
    <x-input-label for="tipo_interno" value="Tipo Interno (Opcional, para uso do sistema)" />
    <x-text-input id="tipo_interno" name="tipo_interno" type="text" class="mt-1 block w-full" 
                  :value="old('tipo_interno', $categoria->tipo_interno ?? '')" />
    <x-input-error :messages="$errors->get('tipo_interno')" class="mt-2" />
</div>
<div class="mt-6 flex justify-end">
    <x-primary-button>
        {{ isset($categoria) ? 'Atualizar Categoria' : 'Salvar Categoria' }}
    </x-primary-button>
</div>
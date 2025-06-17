{{-- resources/views/setores/_form.blade.php --}}

@csrf
{{-- Exibe erros de validação, se houver --}}
@if($errors->any())
    <div class="mb-4">
        <ul class="list-disc list-inside text-sm text-red-600">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div>
    <x-input-label for="name" value="Nome do Setor" />
    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" 
                  :value="old('name', $setor->name ?? '')" required autofocus />
    <x-input-error :messages="$errors->get('name')" class="mt-2" />
</div>

<div class="mt-6 flex justify-end">
    <x-primary-button>
        {{-- O texto do botão muda se estivermos editando ou criando --}}
        {{ isset($setor) ? 'Atualizar Setor' : 'Salvar Setor' }}
    </x-primary-button>
</div>
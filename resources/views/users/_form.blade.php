@csrf
@if ($errors->any())
    <div class="mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg">
        <ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
    </div>
@endif
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <x-input-label for="name" value="Nome" />
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name ?? '')" required />
    </div>
    <div>
        <x-input-label for="email" value="Email" />
        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email ?? '')" required />
    </div>

    {{-- SEÇÃO DE SENHA: SÓ APARECE NA CRIAÇÃO --}}
    @if(!isset($user))
        <div>
            <x-input-label for="password" value="Senha" />
            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required />
        </div>
        <div>
            <x-input-label for="password_confirmation" value="Confirmar Senha" />
            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" required />
        </div>
    @endif
    
    <div>
        <x-input-label for="setor_id" value="Setor" />
        <select id="setor_id" name="setor_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
            <option value="">Nenhum</option>
            @foreach($setores as $setor)
                <option value="{{ $setor->id }}" @selected(old('setor_id', $user->setor_id ?? '') == $setor->id)>{{ $setor->nome }}</option>
            @endforeach
        </select>
    </div>

    <div class="md:col-span-2 mt-4 pt-4 border-t">
        <label class="block font-medium text-sm text-gray-700 mb-2">Cargos</label>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            @foreach ($roles as $role)
                <div class="flex items-center">
                    <input type="checkbox" id="role_{{ $role->id }}" name="roles[]" value="{{ $role->name }}" class="h-4 w-4 text-indigo-600 rounded"
                        @if(isset($user) && $user->hasRole($role->name)) checked @endif >
                    <label for="role_{{ $role->id }}" class="ml-2 block text-sm text-gray-900">{{ $role->name }}</label>
                </div>
            @endforeach
        </div>
    </div>
</div>

<div class="mt-6 flex justify-end">
    <x-primary-button>{{ isset($user) ? 'Atualizar Usuário' : 'Criar Usuário' }}</x-primary-button>
</div>
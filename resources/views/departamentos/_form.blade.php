@csrf
<div>
    <h3 class="text-lg font-semibold text-slate-900">Dados do departamento</h3>
    <div class="mt-6 grid grid-cols-1 gap-y-6">
        <div>
            <x-input-label for="nome" value="Nome do departamento" />
            <div class="mt-1">
                {{-- A lógica '?? ""' garante que o formulário de criação não gere erro --}}
                <x-text-input id="nome" name="nome" type="text" class="block w-full" :value="old('nome', $departamento->nome ?? '')" required autofocus />
            </div>
            <x-input-error :messages="$errors->get('nome')" class="mt-2" />
        </div>
    </div>
</div>
<div class="pt-5 mt-5 border-t border-slate-200">
    <div class="flex justify-end gap-3">
        <a href="{{ route('departamentos.index') }}" class="rounded-md border border-slate-300 bg-white py-2 px-4 text-sm font-medium text-slate-700 shadow-sm hover:bg-slate-50">Cancelar</a>
        <button type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-blue-600 py-2 px-4 text-sm font-semibold text-white shadow-sm hover:bg-blue-700">
            {{ isset($departamento) ? 'Atualizar departamento' : 'Salvar departamento' }}
        </button>
    </div>
</div>
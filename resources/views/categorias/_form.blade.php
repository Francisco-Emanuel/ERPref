@csrf
<div class="space-y-8 divide-y divide-slate-200">
    <div>
        <h3 class="text-lg font-semibold text-slate-900">Dados da Categoria</h3>
        <p class="mt-1 text-sm text-slate-500">Defina um nome amigável para exibição e um nome interno único para o sistema.</p>
        <div class="mt-6 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-6">
            <div>
                <x-input-label for="nome_amigavel" value="Nome da Categoria (Ex: Suporte de TI)" />
                <div class="mt-1">
                    <x-text-input id="nome_amigavel" name="nome_amigavel" type="text" class="block w-full" :value="old('nome_amigavel', $categoria->nome_amigavel ?? '')" required autofocus />
                </div>
            </div>
            <div>
                <x-input-label for="tipo_interno" value="Nome Interno (slug, ex: ti_suporte)" />
                <div class="mt-1">
                    <x-text-input id="tipo_interno" name="tipo_interno" type="text" class="block w-full" :value="old('tipo_interno', $categoria->tipo_interno ?? '')" required />
                </div>
            </div>
        </div>
    </div>
</div>
<div class="pt-5 mt-5 border-t border-slate-200">
    <div class="flex justify-end gap-3">
        <a href="{{ route('categorias.index') }}" class="rounded-md border border-slate-300 bg-white py-2 px-4 text-sm font-medium text-slate-700 hover:bg-slate-50">Cancelar</a>
        <button type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-blue-600 py-2 px-4 text-sm font-semibold text-white hover:bg-blue-700">
            {{ isset($categoria) ? 'Atualizar Categoria' : 'Salvar Categoria' }}
        </button>
    </div>
</div>
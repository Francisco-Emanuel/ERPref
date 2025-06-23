<x-app-layout>
    <div class="bg-slate-50 min-h-screen">
        <header class="bg-white shadow-sm"><div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8"><h1 class="text-2xl font-bold text-slate-900">Editar Ativo: {{ $ativo->nome_ativo }}</h1></div></header>
        <main class="py-12"><div class="max-w-7xl mx-auto sm:px-6 lg:px-8"><div class="bg-white rounded-xl shadow-sm"><div class="p-6 sm:p-8">
            <form method="POST" action="{{ route('ativos.update', $ativo) }}">
                @method('PUT')
                @include('ativos._form', ['ativo' => $ativo])
            </form>
            {{-- A sua seção de lixeira pode vir aqui, dentro do card ou em um card separado --}}
        </div></div></div></main>
    </div>
</x-app-layout>
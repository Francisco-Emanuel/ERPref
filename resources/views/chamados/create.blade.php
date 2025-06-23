<x-app-layout>
    <div class="bg-slate-50 min-h-screen">
        {{-- Cabeçalho da Página --}}
        <header class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="text-2xl font-bold text-slate-900">
                    Abrir Novo Chamado
                </h1>
            </div>
        </header>

        {{-- Conteúdo Principal --}}
        <main class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                {{-- Card que envolve o formulário --}}
                <div class="bg-white rounded-xl shadow-sm">
                    <div class="p-6 sm:p-8">
                        <form method="POST" action="{{ route('chamados.store') }}">
                            {{-- Inclui o formulário que acabamos de criar --}}
                            @include('chamados._form')
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
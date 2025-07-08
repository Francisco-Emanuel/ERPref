<x-app-layout>
    <div class="bg-slate-50 min-h-screen">
        {{-- Cabeçalho --}}
        <header class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-slate-900">
                    Editar Perfil
                </h1>
                {{-- Botão para voltar para a visualização simples do perfil --}}
                <a href="{{ route('profile.show') }}" class="inline-flex items-center gap-2 bg-white text-slate-700 font-semibold py-2 px-4 rounded-lg hover:bg-slate-100 transition-colors border border-slate-200">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                    Voltar ao Perfil
                </a>
            </div>
        </header>

        {{-- Conteúdo Principal com as seções de formulário --}}
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
                {{-- Card para informações do perfil --}}
                <div class="p-6 sm:p-8 bg-white shadow-sm rounded-xl">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                {{-- Card para atualizar a senha --}}
                <div class="p-6 sm:p-8 bg-white shadow-sm rounded-xl" id="update-password-form-section"> {{-- Adicionado ID para âncora --}}
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                {{-- Card para excluir a conta --}}
                <div class="p-6 sm:p-8 bg-white shadow-sm rounded-xl">
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

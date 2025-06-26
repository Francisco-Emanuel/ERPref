<x-app-layout>
    <div class="bg-slate-50 min-h-screen">
        {{-- Cabeçalho --}}
        <header class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="text-2xl font-bold text-slate-900">
                    {{ __('Meu Perfil') }}
                </h1>
            </div>
        </header>

        {{-- Conteúdo Principal --}}
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
                {{-- Card para informações do perfil --}}
                <div class="p-6 sm:p-8 bg-white shadow-sm rounded-xl">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                {{-- Card para atualizar a senha --}}
                <div class="p-6 sm:p-8 bg-white shadow-sm rounded-xl">
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
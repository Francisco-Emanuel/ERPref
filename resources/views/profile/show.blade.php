<x-app-layout>
    <div class="bg-slate-50 min-h-screen">
        {{-- Cabeçalho da Página --}}
        <header class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-slate-900">
                    Meu Perfil
                </h1>
                {{-- Botão para ir para a página de edição completa --}}
                <a href="{{ route('profile.edit') }}" class="inline-flex items-center gap-2 bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                    </svg>
                    Editar Perfil
                </a>
            </div>
        </header>

        {{-- Conteúdo Principal --}}
        <main class="py-12">
            <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white rounded-xl shadow-sm p-6 sm:p-8 text-center">
                    <div class="flex flex-col items-center justify-center mb-6">
                        {{-- SVG de Perfil --}}
                        <svg class="w-24 h-24 text-gray-400 mb-4" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M12 4a4 4 0 100 8 4 4 0 000-8zM2 18a10 10 0 1120 0H2z" clip-rule="evenodd" />
                        </svg>

                        <h2 class="text-2xl font-bold text-slate-900">{{ $user->name }}</h2>
                        <p class="text-md text-slate-600">{{ $user->email }}</p>

                        {{-- Exibição dos Cargos (Roles) --}}
                        <div class="mt-4 flex flex-wrap justify-center gap-2">
                            @forelse ($user->roles as $role)
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ $role->name }}
                                </span>
                            @empty
                                <span class="text-sm text-slate-500">Nenhum cargo atribuído.</span>
                            @endforelse
                        </div>
                    </div>

                    {{-- Link para Editar Senha --}}
                    <div class="mt-8 pt-6 border-t border-slate-200">
                        <a href="{{ route('profile.edit') }}#update-password-form-section" class="inline-flex items-center gap-2 bg-slate-100 text-slate-700 font-semibold py-2 px-4 rounded-lg hover:bg-slate-200 transition-colors border border-slate-200">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3v.256c.354.091.69.21.996.36l-.701-.701A1.5 1.5 0 0017.25 6H13.5a.75.75 0 000 1.5h.396a8.038 8.038 0 01-.975 2.25H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V12.75a3 3 0 013-3V8.25a.75.75 0 000-1.5h-.396a8.038 8.038 0 01-.975-2.25H15.75z" />
                            </svg>
                            Editar Senha
                        </a>
                    </div>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>

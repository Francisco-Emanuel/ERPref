<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> --}}

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div
                class="bg-white shadow-sm sm:rounded-lg flex flex-wrap flex-col items-center justify-around px-6 py-4 gap-2">
                <div>
                    <x-application-logo class="block h-40 w-auto fill-current text-gray-800" />
                    <h1 class=" font-bold text-4xl">Links úteis</h1>
                </div>
                <div class="flex flex-wrap justify-center gap-3 w-full">
                    <a href="{{ route('Ativos.index') }}"
                        class="p-4 bg-blue-500 text-white rounded-md text-lg hover:bg-blue-400">Listar ativos</a>
                    <a href="{{ route('Ativos.criar') }}"
                        class="p-4 bg-blue-500 text-white rounded-md text-lg hover:bg-blue-400">Registrar Ativo</a>
                    <a href="/register"
                        class="p-4 bg-blue-500 text-white rounded-md text-lg hover:bg-blue-400">Cadastrar usuário</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
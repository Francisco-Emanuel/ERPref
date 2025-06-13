<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Registrar Ativo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md sm:rounded-lg px-8 py-6">
                <form method="POST" action="{{ route('Ativos.store') }}">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Tipo do Ativo -->
                        <div>
                            <label for="tipo_ativo" class="block text-sm font-medium text-gray-700 mb-1">Tipo do ativo</label>
                            <input type="text" name="tipo_ativo" class="w-full p-2.5 border border-gray-300 rounded-lg bg-gray-50 text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="computador, impressora..." required />
                        </div>

                        <!-- Identificação -->
                        <div>
                            <label for="identificacao" class="block text-sm font-medium text-gray-700 mb-1">Identificação do ativo</label>
                            <input type="text" name="identificacao" class="w-full p-2.5 border border-gray-300 rounded-lg bg-gray-50 text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="ex: 42069" required />
                        </div>

                        <!-- Setor -->
                        <div>
                            <label for="setor" class="block text-sm font-medium text-gray-700 mb-1">Setor do ativo</label>
                            <input type="text" name="setor" class="w-full p-2.5 border border-gray-300 rounded-lg bg-gray-50 text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="EMEI, RH, TI..." required />
                        </div>

                        <!-- Responsável -->
                        <div>
                            <label for="usuario_responsavel" class="block text-sm font-medium text-gray-700 mb-1">Responsável pelo ativo</label>
                            <input type="text" name="usuario_responsavel" class="w-full p-2.5 border border-gray-300 rounded-lg bg-gray-50 text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Fulano" required />
                        </div>

                        <!-- Status (toggle) -->
                        <div x-data="{ status: false }">
                        <label class="inline-flex items-center mb-5 cursor-pointer">
                            <input type="checkbox" x-model="status" name="status" value="1" class="sr-only peer">
                            <div class="relative w-11 h-6 bg-red-300 peer-focus:outline-none rounded-full 
                                        peer peer-checked:after:translate-x-full 
                                        rtl:peer-checked:after:-translate-x-full 
                                        peer-checked:after:border-white 
                                        after:content-[''] after:absolute after:top-[2px] after:start-[2px] 
                                        after:bg-white after:border-gray-300 after:border after:rounded-full 
                                        after:w-5 after:h-5 after:transition-all 
                                        peer-checked:bg-green-300"></div>
                            <span :class="status ? 'text-green-600' : 'text-red-500'" class="ms-3 text-sm font-medium">
                            <span x-text="status ? 'Status (OK)' : 'Status (Problema)'"></span>
                            </span>
                        </label>
                    </div>

                        <!-- Descrição -->
                        <div class="md:col-span-2">
                            <label for="descricao_problema" class="block text-sm font-medium text-gray-700 mb-1">Descrição do problema</label>
                            <textarea name="descricao_problema" rows="4" class="w-full p-2.5 border border-gray-300 rounded-lg bg-gray-50 text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Computador fazendo barulho..."></textarea>
                        </div>
                    </div>

                    <!-- Botão -->
                    <div class="mt-6">
                        <button type="submit" class="w-full md:w-auto px-6 py-2.5 bg-blue-700 text-white text-sm font-medium rounded-lg hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 transition">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>



<x-modal name="resolve-chamado-modal" focusable>
        <form method="post" action="{{ route('chamados.resolve', $chamado) }}" class="p-6">
            @csrf
            @method('patch')

            <h2 class="text-lg font-medium text-gray-900">
                Registrar Solução do Chamado #{{ $chamado->id }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                Descreva detalhadamente a solução aplicada para resolver o problema do usuário. Esta informação será
                visível para o solicitante.
            </p>

            <div class="mt-6">
                <x-input-label for="solucao_final" value="Descrição da Solução" />
                <textarea id="solucao_final" name="solucao_final" rows="5"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                    required minlength="10">{{ old('solucao_final') }}</textarea>
                <x-input-error :messages="$errors->get('solucao_final')" class="mt-2" />
            </div>

            <div class="mt-6">
                <label for="servico_executado" class="flex items-center">
                    <input type="checkbox" id="servico_executado" name="servico_executado"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm" required>
                    <span class="ms-2 text-sm text-gray-700">Confirmo que o serviço foi executado e o problema
                        resolvido.</span>
                </label>
                <x-input-error :messages="$errors->get('servico_executado')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    Cancelar
                </x-secondary-button>

                <x-primary-button class="ms-3">
                    Confirmar Resolução
                </x-primary-button>
            </div>
        </form>
    </x-modal>
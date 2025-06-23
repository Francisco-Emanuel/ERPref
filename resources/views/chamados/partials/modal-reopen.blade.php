<x-modal name="reopen-chamado-modal" focusable>
        <form method="post" action="{{ route('chamados.reopen', $chamado) }}" class="p-6">
            @csrf
            @method('patch')

            <h2 class="text-lg font-medium text-gray-900">
                Reabrir Chamado #{{ $chamado->id }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                Por favor, descreva por que você precisa reabrir este chamado. O problema retornou ou a solução não foi eficaz?
            </p>

            <div class="mt-6">
                <x-input-label for="motivo_reabertura" value="Motivo da Reabertura" />
                <textarea id="motivo_reabertura" name="motivo_reabertura" rows="5" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required></textarea>
                <x-input-error :messages="$errors->get('motivo_reabertura')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    Cancelar
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    Confirmar e Reabrir
                </x-danger-button>
            </div>
        </form>
    </x-modal>
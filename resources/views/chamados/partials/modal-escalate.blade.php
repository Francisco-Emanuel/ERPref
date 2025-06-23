<x-modal name="escalate-chamado-modal" focusable>
        <form method="post" action="{{ route('chamados.escalate', $chamado) }}" class="p-6">
            @csrf
            @method('patch')

            <h2 class="text-lg font-medium text-gray-900">
                Escalar Chamado #{{ $chamado->id }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                Selecione o técnico para quem você deseja transferir a responsabilidade deste chamado.
            </p>

            <div class="mt-6">
                <x-input-label for="new_tecnico_id" value="Atribuir Para" />
                <select id="new_tecnico_id" name="new_tecnico_id"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="">Selecione um técnico...</option>
                    @foreach ($tecnicosDisponiveis as $tecnico)
                        <option value="{{ $tecnico->id }}">{{ $tecnico->name }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('new_tecnico_id')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    Cancelar
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    Confirmar Escalação
                </x-danger-button>
            </div>
        </form>
    </x-modal>
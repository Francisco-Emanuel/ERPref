<x-modal :name="'atribuir-chamado-' . $chamado->id" focusable>
    <form method="post" action="{{ route('chamados.atribuir', $chamado) }}" class="p-6">
        @csrf
        @method('patch')
        <h2 class="text-lg font-medium text-gray-900">Atribuir / Escalar Chamado #{{ $chamado->id }}</h2>
        <p class="mt-1 text-sm text-gray-600">Selecione o técnico para quem você deseja transferir este chamado.</p>
        <div class="mt-6">
            <x-input-label for="new_tecnico_id_{{ $chamado->id }}" value="Atribuir Para" />
            <select id="new_tecnico_id_{{ $chamado->id }}" name="new_tecnico_id"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                <option value="">Selecione um técnico...</option>
                @foreach ($tecnicosDisponiveis as $tecnico)
                    @if($chamado->tecnico_id !== $tecnico->id)
                        <option value="{{ $tecnico->id }}">{{ $tecnico->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">Cancelar</x-secondary-button>
            <x-danger-button class="ms-3">Confirmar</x-danger-button>
        </div>
    </form>
</x-modal>
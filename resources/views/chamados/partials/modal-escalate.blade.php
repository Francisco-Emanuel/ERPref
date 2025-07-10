<x-modal name="escalate-chamado-modal" focusable>
        <form id="escalate-chamado-form" method="POST" action="{{ route('chamados.atribuir', $chamado) }}">
    @csrf
    @method('PATCH') {{-- Garanta que este método está presente --}}

    {{-- Seu select para escolher o novo técnico --}}
    <div class="mt-4">
        <label for="new_tecnico_id" class="block font-medium text-sm text-gray-700">Novo Técnico</label>
        <select name="new_tecnico_id" id="new_tecnico_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
            @foreach($tecnicosDisponiveis as $tecnico)
                <option value="{{ $tecnico->id }}">{{ $tecnico->name }}</option>
            @endforeach
        </select>
    </div>

    {{-- Seus botões de confirmar e cancelar --}}
    <div class="mt-6 flex justify-end">
        <x-secondary-button type="button" x-on:click="$dispatch('close')">
            Cancelar
        </x-secondary-button>
        <x-primary-button class="ms-3">
            Confirmar Escalação
        </x-primary-button>
    </div>
</form>
    </x-modal>
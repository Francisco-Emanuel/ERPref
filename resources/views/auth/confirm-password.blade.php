<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Área Segura</h1>
        <p>Esta é uma área segura da aplicação. Por favor, confirme a sua senha antes de continuar.</p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="mt-6 space-y-6">
        @csrf

        <!-- Senha -->
        <div>
            <x-input-label for="password" :value="__('Senha')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                Confirmar
            </button>
        </div>
    </form>
</x-guest-layout>
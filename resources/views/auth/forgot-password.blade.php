<x-guest-layout>
    <div class="text-left mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Esqueceu a sua senha?</h1>
        <p class="mt-2 text-sm text-gray-500">
            Sem problemas. Indique o seu endereço de e-mail e enviaremos um link para que possa criar uma nova senha.
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                Enviar Link de Redefinição
            </button>
        </div>
    </form>
</x-guest-layout>
<x-guest-layout>
    {{-- Este é o conteúdo que será inserido no $slot do guest-layout --}}
    
    <div class="text-left mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Acessar Sistema</h1>
        <p class="mt-2 text-sm text-gray-500">Bem-vindo de volta!</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="my-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email -->
        <div>
            <x-input-label for="email" value="Endereço de e-mail" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" class="mt-1 block w-full" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Senha -->
        <div>
            <div class="flex justify-between items-baseline">
                <x-input-label for="password" value="Senha" />
                @if (Route::has('password.request'))
                    <a class="text-sm text-blue-600 hover:underline" href="{{ route('password.request') }}">
                        Esqueceu a senha?
                    </a>
                @endif
            </div>
            <x-text-input id="password" type="password" name="password" class="mt-1 block w-full" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        
        <!-- Lembrar-me -->
        <div>
             <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-600" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Lembrar-me') }}</span>
            </label>
        </div>

        <!-- Botão de Envio -->
        <div class="pt-2">
            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Entrar
            </button>
        </div>
    </form>
</x-guest-layout>
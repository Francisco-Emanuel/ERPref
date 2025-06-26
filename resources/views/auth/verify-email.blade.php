<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Verifique o seu E-mail</h1>
        <p>Obrigado por se inscrever! Antes de começar, poderia verificar o seu endereço de e-mail clicando no link que acabámos de lhe enviar? Se não recebeu o e-mail, teremos todo o prazer em lhe enviar outro.</p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            Um novo link de verificação foi enviado para o endereço de e-mail que forneceu durante o registo.
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                Reenviar E-mail de Verificação
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md ms-2">
                Sair
            </button>
        </form>
    </div>
</x-guest-layout>
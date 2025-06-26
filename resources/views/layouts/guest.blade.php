<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="icon" href="{{ asset('logo.png') }}" type="image/png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen bg-gray-100">
        <div class="flex flex-col md:flex-row min-h-screen">

            <!-- Painel Esquerdo (Branding) -->
            <div
                class="hidden md:flex md:w-5/12 lg:w-1/3 bg-slate-800 flex-col justify-center items-center p-12 text-white text-center">
                <div class="w-full flex-col flex justify-center items-center text-center">
                    <a href="/">
                        {{-- O logo da aplicação --}}
                        <x-application-logo class="w-24 h-24 fill-current" />
                    </a>
                    <h1 class="mt-6 text-3xl font-bold">PREF Desk</h1>
                    <p class="mt-2 text-slate-300">Sistema de Gestão de Chamados</p>
                </div>
                <p class="text-slate-600">Made by Francisco Soares</p>
            </div>

            <!-- Painel Direito (Conteúdo do Formulário) -->
            <div class="w-full md:w-7/12 lg:w-2/3 flex items-center justify-center p-6 sm:p-12">
                <div class="w-full max-w-md">
                    {{-- O $slot é onde o conteúdo de login.blade.php, etc., será injetado --}}
                    {{ $slot }}
                </div>
            </div>

        </div>
    </div>
</body>

</html>
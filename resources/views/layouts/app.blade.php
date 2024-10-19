<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Page-specific styles -->
    @if (Route::is('leads.show', 'leads.edit'))
        <style>
            .slider {
                -webkit-appearance: none;
                border-radius: 0.375rem;
                width: 100%;
                height: 25px;
                background: #d3d3d3;
                outline: none;
                opacity: 0.7;
                -webkit-transition: .2s;
                transition: opacity .2s;
            }

            .slider:hover {
                opacity: 1;
            }

            .slider::-webkit-slider-thumb {
                -webkit-appearance: none;
                appearance: none;
                border-radius: 0.375rem;
                width: 25px;
                height: 25px;
                background: var(--thumb-color, #F2CA02);
                cursor: pointer;
            }

            .slider::-moz-range-thumb {
                width: 25px;
                height: 25px;
                border-radius: 0.375rem;
                background: var(--thumb-color, #F2CA02);
                cursor: pointer;
            }
            .slider-values p{
                width: 25px;
                text-align: center;
            }
        </style>
    @endif
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 flex flex-col">
        @include('layouts.navigation')
        <!-- Page Heading -->
        <!--
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset
            -->

        <!-- Page Content -->
        <main class="flex-1 flex flex-col h-full relative">
            {{ $slot }}
        </main>
    </div>
</body>

</html>
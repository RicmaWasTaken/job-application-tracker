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

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div class="h-3/5 flex flex-col justify-start gap-20">
                <div class="text-center flex flex-col gap-10">
                    <h1 class="text-5xl">JOB TRACKER</h1>
                    <h2 class="text-3xl">The best companion for your job-hunting adventure</h2>
                </div>
                <div class="box-border flex flex-row gap-40 justify-center">
                    <a href="/register" class="py-3 text-xl min-w-32 text-center rounded-lg text-indigo-400 border-2 border-indigo-400">Register</a>
                    <a href="/login" class="py-3 text-xl min-w-32 text-center rounded-lg bg-indigo-400 text-gray-100">Login</a>
                </div>
            </div>
        </div>
    </body>
</html>

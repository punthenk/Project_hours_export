<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @vite('resources/css/app.css')

        <title>{{ config('app.name', 'Hours Export') }}</title>
    </head>
    <body class="min-h-screen bg-gray-100 p-8">
        <main>
            {{ $slot }}
        </main>
        <script src="{{ asset('js/main.js') }}"></script>
        <script src="{{ asset('js/popup.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script>
    </body>
</html>

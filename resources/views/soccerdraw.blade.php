<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zeichenprogramm - trainercontainer.de</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="font-sans bg-gray-100">
    <div id="app">
        <!-- Header -->
        <header class="bg-white shadow-md">
            <div class="container mx-auto px-4 py-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <a href="{{ route('welcome') }}"><img src="{{ asset('images/logo_trainercontainer.png') }}" class="h-12 w-auto mr-4" alt="Logo" /></a>
                        <h1 class="text-2xl font-bold text-gray-800">Zeichenprogramm Fußball</h1>
                    </div>
                    <div class="flex space-x-4">
                        @auth
                            <a href="{{ route('dashboard') }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                                Login
                            </a>
                            <a href="{{ route('register') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                                Register
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="container mx-auto px-4 py-8">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">Erstelle Fußballübungen</h2>
                    <p class="text-gray-600">Nutze unser Zeichentool um schnell und einfach Übungen zu zeichnen und bei uns hochzuladen!</p>
                </div>

                <div id="vue-canvas-app"></div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-gray-800 text-white py-8 mt-12">
            <div class="container mx-auto px-4 text-center">
                <p>&copy; {{ date('Y') }} {{ config('APP_NAME') }}. All rights reserved.</p>
                <div class="mt-4">
                    <a href="{{ route('imprint') }}" class="text-gray-300 hover:text-white mx-2">Imprint</a>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>

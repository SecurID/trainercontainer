<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">

        <!-- Styles -->
        @vite(['resources/css/app.css','resources/js/app.js'])
        <link rel="stylesheet" href="{{ asset('css/ui-autocomplete.css') }}">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        @livewireStyles
        @stack('styles')
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800 antialiased">
            <flux:header class="bg-white container border-b border-zinc-200">
                <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

                <div class="flex items-center max-lg:hidden">
                    <div class="w-10 h-10 bg-zinc-800 rounded-full flex items-center justify-center">
                        <span class="text-white text-xl font-bold">t</span>
                    </div>
                    <span class="ml-3 text-xl font-bold text-zinc-900">trainercontainer</span>
                </div>

                <flux:navbar class="ml-6 max-lg:hidden">
                    <flux:navbar.item href="{{ route('dashboard') }}" :current="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </flux:navbar.item>
                    <flux:navbar.item href="{{ route('practices.index') }}" :current="request()->routeIs('practices.*')">
                        {{ __('Practices') }}
                    </flux:navbar.item>
                    <flux:navbar.item href="{{ route('exercises.index') }}" :current="request()->routeIs('exercises.*')">
                        {{ __('Exercises') }}
                    </flux:navbar.item>
                    <flux:navbar.item href="{{ route('players.index') }}" :current="request()->routeIs('players.*')">
                        {{ __('Players') }}
                    </flux:navbar.item>
                    <flux:navbar.item href="{{ route('games.index') }}" :current="request()->routeIs('games.*')">
                        {{ __('Games') }}
                    </flux:navbar.item>
                    <flux:navbar.item href="{{ route('opponents.index') }}" :current="request()->routeIs('opponents.*')">
                        {{ __('Opponents') }}
                    </flux:navbar.item>
                </flux:navbar>

                <flux:spacer />

                <livewire:language-switcher />

                <flux:dropdown position="top" align="end">
                    <flux:button variant="ghost" class="p-0">
                        <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                    </flux:button>

                    <flux:menu>
                        <flux:menu.heading>{{ __('Manage Account') }}</flux:menu.heading>

                        <flux:menu.item href="/user/profile" icon="user">
                            {{ __('Profile') }}
                        </flux:menu.item>

                        @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                            <flux:menu.item href="/user/api-tokens" icon="key">
                                {{ __('API Tokens') }}
                            </flux:menu.item>
                        @endif

                        <flux:menu.separator />

                        <form method="POST" action="{{ route('logout') }}" x-data>
                            @csrf
                            <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle">
                                {{ __('Logout') }}
                            </flux:menu.item>
                        </form>
                    </flux:menu>
                </flux:dropdown>
            </flux:header>

            <!-- Mobile Sidebar -->
            <flux:sidebar stashable sticky class="lg:hidden bg-white border-r border-zinc-200">
                <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

                <flux:navlist variant="outline">
                    <flux:navlist.item href="{{ route('dashboard') }}" :current="request()->routeIs('dashboard')" icon="home">
                        {{ __('Dashboard') }}
                    </flux:navlist.item>
                    <flux:navlist.item href="{{ route('practices.index') }}" :current="request()->routeIs('practices.*')" icon="calendar">
                        {{ __('Practices') }}
                    </flux:navlist.item>
                    <flux:navlist.item href="{{ route('exercises.index') }}" :current="request()->routeIs('exercises.*')" icon="clipboard-document-list">
                        {{ __('Exercises') }}
                    </flux:navlist.item>
                    <flux:navlist.item href="{{ route('players.index') }}" :current="request()->routeIs('players.*')" icon="users">
                        {{ __('Players') }}
                    </flux:navlist.item>
                    <flux:navlist.item href="{{ route('games.index') }}" :current="request()->routeIs('games.*')" icon="trophy">
                        {{ __('Games') }}
                    </flux:navlist.item>
                    <flux:navlist.item href="{{ route('opponents.index') }}" :current="request()->routeIs('opponents.*')" icon="user-group">
                        {{ __('Opponents') }}
                    </flux:navlist.item>
                </flux:navlist>

                <flux:spacer />

                <flux:navlist variant="outline">
                    <flux:navlist.item href="/user/profile" icon="cog-6-tooth">
                        {{ __('Profile') }}
                    </flux:navlist.item>
                </flux:navlist>
            </flux:sidebar>

            <!-- Page Heading -->
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        <script
            src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
            crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        @stack('modals')
        @livewireScripts
        @stack('jsscripts')
        @stack('scripts')
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-0XLX9M5RC6"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'G-0XLX9M5RC6');
        </script>
        @fluxScripts
        <flux:toast />
    </body>
</html>

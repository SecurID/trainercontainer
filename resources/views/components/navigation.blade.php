<flux:header container class="bg-white border-b border-zinc-200">
    <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

    <a href="{{ route('dashboard') }}" class="flex items-center max-lg:hidden">
        <div class="w-10 h-10 bg-zinc-800 rounded-full flex items-center justify-center">
            <span class="text-white text-xl font-bold">t</span>
        </div>
        <span class="ml-3 text-xl font-bold text-zinc-900">trainercontainer</span>
    </a>

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

            <flux:menu.item href="{{ route('profile.show') }}" icon="user">
                {{ __('Profile') }}
            </flux:menu.item>

            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                <flux:menu.item href="{{ route('api-tokens.index') }}" icon="key">
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

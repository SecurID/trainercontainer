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
        <flux:navlist.item href="{{ route('profile.show') }}" icon="cog-6-tooth">
            {{ __('Profile') }}
        </flux:navlist.item>
    </flux:navlist>
</flux:sidebar>

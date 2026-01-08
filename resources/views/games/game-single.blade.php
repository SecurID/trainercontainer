<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <x-back-button></x-back-button>
                <flux:heading size="xl">
                    {{ __('Game') }}: {{ \Carbon\Carbon::parse($game->date)->format('d.m.Y') }}
                    - {{ $game->opponent?->name ?? '-' }}
                </flux:heading>
            </div>
            <flux:button href="{{ route('games.edit', $game->id) }}" icon="pencil">
                {{ __('Edit') }}
            </flux:button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <flux:card>
                <!-- Game Details -->
                <div class="mb-6">
                    <flux:heading size="lg" class="mb-4">{{ __('Game Details') }}</flux:heading>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <flux:text size="sm" class="text-zinc-600">{{ __('Opponent') }}</flux:text>
                            <flux:text class="font-semibold">{{ $game->opponent?->name ?? '-' }}</flux:text>
                        </div>
                        @if($game->opponent_formation)
                            <div>
                                <flux:text size="sm" class="text-zinc-600">{{ __('Opponent Formation') }}</flux:text>
                                <flux:badge>{{ $game->opponent_formation }}</flux:badge>
                            </div>
                        @endif
                        <div>
                            <flux:text size="sm" class="text-zinc-600">{{ __('Date') }}</flux:text>
                            <flux:text class="font-semibold">{{ \Carbon\Carbon::parse($game->date)->format('d.m.Y') }}</flux:text>
                        </div>
                        @if($game->time)
                            <div>
                                <flux:text size="sm" class="text-zinc-600">{{ __('Time') }}</flux:text>
                                <flux:text class="font-semibold">{{ $game->time }} {{ __('Uhr') }}</flux:text>
                            </div>
                        @endif
                        @if($game->location)
                            <div>
                                <flux:text size="sm" class="text-zinc-600">{{ __('Location') }}</flux:text>
                                <flux:text class="font-semibold">{{ $game->location }}</flux:text>
                            </div>
                        @endif
                    </div>
                    @if($game->notes)
                        <div class="mt-4">
                            <flux:text size="sm" class="text-zinc-600">{{ __('Notes') }}</flux:text>
                            <flux:text class="mt-1">{{ $game->notes }}</flux:text>
                        </div>
                    @endif
                </div>

                <flux:separator />

                <!-- Player Ratings -->
                <div class="mt-6">
                    <livewire:game-ratings-table :game="$game"/>
                </div>
            </flux:card>
        </div>
    </div>
</x-app-layout>

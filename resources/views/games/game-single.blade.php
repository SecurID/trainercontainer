<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <x-back-button></x-back-button>
            <h2 class="ml-2 text-xl font-semibold text-gray-800 leading-tight">
                {{__('Game')}}: {{ \Carbon\Carbon::parse($game->date)->format('d.m.Y') }}
                - {{ $game->opponent }}
            </h2>
            <a href="{{ route('games.edit', $game->id) }}">
                <button class="ml-auto px-4 py-2 text-white bg-blue-500 hover:bg-blue-700 rounded-lg">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z" fill="white"/>
                    </svg>
                </button>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                
                <!-- Game Details -->
                <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <h3 class="text-lg font-semibold mb-3">{{ __('Game Details') }}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <strong>{{ __('Opponent') }}:</strong> {{ $game->opponent }}
                        </div>
                        <div>
                            <strong>{{ __('Date') }}:</strong> {{ \Carbon\Carbon::parse($game->date)->format('d.m.Y') }}
                        </div>
                        @if($game->time)
                        <div>
                            <strong>{{ __('Time') }}:</strong> {{ $game->time }} {{ __('Uhr') }}
                        </div>
                        @endif
                        @if($game->location)
                        <div>
                            <strong>{{ __('Location') }}:</strong> {{ $game->location }}
                        </div>
                        @endif
                    </div>
                    @if($game->notes)
                    <div class="mt-4">
                        <strong>{{ __('Notes') }}:</strong>
                        <p class="mt-1">{{ $game->notes }}</p>
                    </div>
                    @endif
                </div>

                <!-- Player Ratings -->
                <livewire:game-ratings-table :game="$game"/>
            </div>
        </div>
    </div>
</x-app-layout>
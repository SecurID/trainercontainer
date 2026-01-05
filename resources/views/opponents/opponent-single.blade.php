@php use Illuminate\Support\Carbon; @endphp
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <x-back-button></x-back-button>
            <h2 class="ml-2 text-xl font-semibold text-gray-800 leading-tight">
                {{__('Opponent')}}: {{ $opponent->name }}
            </h2>
            <a href="{{ route('opponents.edit', $opponent->id) }}">
                <button class="ml-auto px-4 py-2 text-white bg-blue-500 hover:bg-blue-700 rounded-lg">
                    <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z" fill="white"/>
                    </svg>
                </button>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                <!-- Opponent Details -->
                <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <h3 class="text-lg font-semibold mb-3">{{ __('Opponent Details') }}</h3>
                    <div>
                        <strong>{{ __('Name') }}:</strong> {{ $opponent->name }}
                    </div>
                    @if($opponent->notes)
                    <div class="mt-4">
                        <strong>{{ __('Notes') }}:</strong>
                        <p class="mt-1">{{ $opponent->notes }}</p>
                    </div>
                    @endif
                </div>

                <!-- Games Against This Opponent -->
                <div class="mt-6">
                    <h3 class="text-lg font-semibold mb-3">{{ __('Games') }} ({{ count($games) }})</h3>
                    @if(count($games) === 0)
                        <p class="text-gray-600">{{ __("No games found against this opponent.") }}</p>
                    @else
                        <table class="w-full">
                            <thead class="border-b">
                            <tr>
                                <th class="pb-2 text-left">{{__('Date')}}</th>
                                <th class="pb-2 text-left">{{__('Time')}}</th>
                                <th class="pb-2 text-left">{{__('Location')}}</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($games as $game)
                                <tr class="border-b">
                                    <td class="py-2">
                                        <a href="{{ route('games.show', $game->id) }}"
                                           class="text-primary-600 hover:text-primary-800">
                                            {{ Carbon::parse($game->date)->format('d.m.Y') }}
                                        </a>
                                    </td>
                                    <td class="py-2">
                                        {{ $game->time ?? '-' }}
                                    </td>
                                    <td class="py-2">
                                        {{ $game->location ?? '-' }}
                                    </td>
                                    <td class="py-2">
                                        <a href="{{ route('games.show', $game->id) }}">
                                            <x-button class="px-3 py-1 text-white bg-primary-600 hover:bg-primary-700 rounded text-sm">
                                                {{ __('View') }}
                                            </x-button>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>

                <!-- Game Notes Section -->
                @if($games->where('notes', '!=', null)->count() > 0)
                <div class="mt-6">
                    <h3 class="text-lg font-semibold mb-3">{{ __('Game Notes') }}</h3>
                    <div class="space-y-4">
                        @foreach($games->where('notes', '!=', null) as $game)
                            <div class="p-4 bg-gray-50 rounded-lg border-l-4 border-primary-500">
                                <div class="flex justify-between items-start mb-2">
                                    <div class="font-semibold text-gray-700">
                                        {{ Carbon::parse($game->date)->format('d.m.Y') }}
                                        @if($game->time)
                                            - {{ $game->time }}
                                        @endif
                                        @if($game->location)
                                            - {{ $game->location }}
                                        @endif
                                        @if($game->opponent_formation)
                                            - {{ $game->opponent_formation }}
                                        @endif
                                    </div>
                                    <a href="{{ route('games.show', $game->id) }}" class="text-primary-600 hover:text-primary-800 text-sm">
                                        {{ __('View Game') }}
                                    </a>
                                </div>
                                <p class="text-gray-600">{{ $game->notes }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

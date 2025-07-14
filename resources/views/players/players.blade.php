<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="text-xl font-semibold text-gray-800 leading-tight">
                {{ __('Players') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('players.position-analysis') }}">
                    <x-secondary-button class="px-4 py-2 bg-green-500 text-white font-bold rounded hover:bg-green-700">
                        {{ __('Position Analysis') }}
                    </x-secondary-button>
                </a>
                <a href="/players/create">
                    <x-button>
                        {{ __('Create Player') }}
                    </x-button>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-4">
                    @if(count($players) === 0)
                        <p class="p-2">{{ __('No players found.') }} {{ __('Create one by clicking on "Create Player".') }}</p>
                    @endif
                    @foreach($players as $player)
                        <a href="{{ route('players.show', $player->id) }}" class="block px-4 py-2 mt-2 bg-gray-100 rounded hover:bg-gray-200">
                            {{$player->lastname}}, {{$player->prename}}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

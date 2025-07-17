@php use Illuminate\Support\Carbon; @endphp
<x-app-layout>
    <x-slot name="header">
        <div class="lg:flex sm:space-y-2 justify-between block">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Games') }}
            </h2>
            <div class="flex space-x-2">
                <div>
                    <a href="{{ route('games.create') }}">
                        <x-button class="px-4 py-2 text-white bg-primary-600 hover:bg-primary-700 rounded-lg">
                            {{ __('Create Game') }}
                        </x-button>
                    </a>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if(count($games) === 0)
                    {{ __("No games found.") }} {{ __('Create one by clicking on "Create Game".') }}
                @else
                    <table class="w-full">
                        <thead class="border-b">
                        <tr>
                            <th class="pb-2 text-left">{{__('Choose a Game to view')}}</th>
                            <th class="pb-2 text-left">{{__('Date')}}</th>
                            <th class="pb-2 text-left">{{__('Opponent')}}</th>
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
                                        {{ Carbon::parse($game->date)->locale(app()->getLocale())->translatedFormat('l') }}
                                        - {{ Carbon::parse($game->date)->format('d.m.Y') }}
                                        @if($game->time)
                                            - {{ $game->time }} {{ __('Uhr') }}
                                        @endif
                                    </a>
                                </td>
                                <td class="py-2">
                                    {{ Carbon::parse($game->date)->format('d.m.Y') }}
                                </td>
                                <td class="py-2">
                                    {{ $game->opponent }}
                                </td>
                                <td class="py-2">
                                    {{ $game->location ?? '-' }}
                                </td>
                                <td class="py-2">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('games.edit', $game->id) }}">
                                            <x-button class="px-3 py-1 text-white bg-blue-500 hover:bg-blue-700 rounded text-sm">
                                                {{ __('Edit') }}
                                            </x-button>
                                        </a>
                                        <form action="{{ route('games.destroy', $game->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="px-3 py-1 text-white bg-red-500 hover:bg-red-700 rounded text-sm"
                                                    onclick="return confirm('{{__('Are you sure you want to delete this game?')}}')">
                                                {{ __('Delete') }}
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
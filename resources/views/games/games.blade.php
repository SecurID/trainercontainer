@php use Illuminate\Support\Carbon; @endphp
<x-app-layout>
    <x-slot name="header">
        <div class="lg:flex sm:space-y-2 justify-between items-center block">
            <flux:heading size="xl">
                {{ __('Games') }}
            </flux:heading>
            <div class="flex gap-2">
                <flux:button href="{{ route('games.create') }}" variant="primary">
                    {{ __('Create Game') }}
                </flux:button>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if(count($games) === 0)
                    <flux:text>{{ __("No games found.") }} {{ __('Create one by clicking on "Create Game".') }}</flux:text>
                @else
                    <table class="w-full">
                        <thead class="border-b">
                        <tr>
                            <th class="pb-2 text-left">{{ __('Choose a Game to view') }}</th>
                            <th class="pb-2 text-left">{{ __('Date') }}</th>
                            <th class="pb-2 text-left">{{ __('Opponent') }}</th>
                            <th class="pb-2 text-left">{{ __('Formation') }}</th>
                            <th class="pb-2 text-left">{{ __('Location') }}</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($games as $game)
                            <tr class="border-b">
                                <td class="py-2">
                                    <flux:link href="{{ route('games.show', $game->id) }}">
                                        {{ Carbon::parse($game->date)->locale(app()->getLocale())->translatedFormat('l') }}
                                        - {{ Carbon::parse($game->date)->format('d.m.Y') }}
                                        @if($game->time)
                                            - {{ $game->time }} {{ __('Uhr') }}
                                        @endif
                                    </flux:link>
                                </td>
                                <td class="py-2">
                                    {{ Carbon::parse($game->date)->format('d.m.Y') }}
                                </td>
                                <td class="py-2">
                                    {{ $game->opponent?->name ?? '-' }}
                                </td>
                                <td class="py-2">
                                    {{ $game->opponent_formation ?? '-' }}
                                </td>
                                <td class="py-2">
                                    {{ $game->location ?? '-' }}
                                </td>
                                <td class="py-2">
                                    <div class="flex gap-2">
                                        <flux:button href="{{ route('games.edit', $game->id) }}" size="sm">
                                            {{ __('Edit') }}
                                        </flux:button>
                                        <form action="{{ route('games.destroy', $game->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <flux:button
                                                type="submit"
                                                variant="danger"
                                                size="sm"
                                                onclick="return confirm('{{ __('Are you sure you want to delete this game?') }}')"
                                            >
                                                {{ __('Delete') }}
                                            </flux:button>
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

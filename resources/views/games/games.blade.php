@php use Illuminate\Support\Carbon; @endphp
<x-app-layout>
    <x-slot name="header">
        <div class="lg:flex sm:space-y-2 justify-between items-center block">
            <flux:heading size="xl">
                {{ __('Games') }}
            </flux:heading>
            <div class="flex gap-2">
                <flux:button href="{{ route('games.create') }}" variant="primary" icon="plus">
                    {{ __('Create Game') }}
                </flux:button>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <flux:card>
                @if(count($games) === 0)
                    <div class="text-center py-8">
                        <flux:icon name="calendar" class="mx-auto size-12 text-zinc-400" />
                        <flux:heading size="lg" class="mt-4">{{ __('No games found') }}</flux:heading>
                        <flux:text class="mt-2">{{ __('Create one by clicking on "Create Game".') }}</flux:text>
                        <flux:button href="{{ route('games.create') }}" variant="primary" icon="plus" class="mt-4">
                            {{ __('Create Game') }}
                        </flux:button>
                    </div>
                @else
                    <flux:table>
                        <flux:table.columns>
                            <flux:table.column>{{ __('Game') }}</flux:table.column>
                            <flux:table.column>{{ __('Date') }}</flux:table.column>
                            <flux:table.column>{{ __('Opponent') }}</flux:table.column>
                            <flux:table.column>{{ __('Formation') }}</flux:table.column>
                            <flux:table.column>{{ __('Location') }}</flux:table.column>
                            <flux:table.column></flux:table.column>
                        </flux:table.columns>
                        <flux:table.rows>
                            @foreach($games as $game)
                                <flux:table.row>
                                    <flux:table.cell>
                                        <flux:link href="{{ route('games.show', $game->id) }}">
                                            {{ Carbon::parse($game->date)->locale(app()->getLocale())->translatedFormat('l') }}
                                            - {{ Carbon::parse($game->date)->format('d.m.Y') }}
                                            @if($game->time)
                                                - {{ $game->time }} {{ __('Uhr') }}
                                            @endif
                                        </flux:link>
                                    </flux:table.cell>
                                    <flux:table.cell>
                                        {{ Carbon::parse($game->date)->format('d.m.Y') }}
                                    </flux:table.cell>
                                    <flux:table.cell>
                                        {{ $game->opponent?->name ?? '-' }}
                                    </flux:table.cell>
                                    <flux:table.cell>
                                        @if($game->opponent_formation)
                                            <flux:badge size="sm">{{ $game->opponent_formation }}</flux:badge>
                                        @else
                                            -
                                        @endif
                                    </flux:table.cell>
                                    <flux:table.cell>
                                        {{ $game->location ?? '-' }}
                                    </flux:table.cell>
                                    <flux:table.cell>
                                        <div class="flex gap-2 justify-end">
                                            <flux:button href="{{ route('games.edit', $game->id) }}" size="sm" icon="pencil" />
                                            <form action="{{ route('games.destroy', $game->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <flux:button
                                                    type="submit"
                                                    variant="danger"
                                                    size="sm"
                                                    icon="trash"
                                                    onclick="return confirm('{{ __('Are you sure you want to delete this game?') }}')"
                                                />
                                            </form>
                                        </div>
                                    </flux:table.cell>
                                </flux:table.row>
                            @endforeach
                        </flux:table.rows>
                    </flux:table>
                @endif
            </flux:card>
        </div>
    </div>
</x-app-layout>

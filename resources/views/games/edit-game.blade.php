<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <x-back-button></x-back-button>
            <flux:heading size="xl">{{ __('Edit Game') }}</flux:heading>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <flux:card>
                <form action="{{ route('games.update', $game->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <flux:field>
                            <flux:label>{{ __('Opponent') }}</flux:label>
                            <flux:select name="opponent_id" variant="listbox" placeholder="{{ __('Select opponent') }}">
                                @foreach($opponents as $opponent)
                                    <flux:select.option value="{{ $opponent->id }}" :selected="old('opponent_id', $game->opponent_id) == $opponent->id">
                                        {{ $opponent->name }}
                                    </flux:select.option>
                                @endforeach
                            </flux:select>
                            <flux:error name="opponent_id" />
                        </flux:field>

                        <flux:field>
                            <flux:label>{{ __('Opponent Formation') }}</flux:label>
                            <flux:select name="opponent_formation" variant="listbox" placeholder="{{ __('Select formation') }}">
                                @foreach($formations as $formation)
                                    <flux:select.option value="{{ $formation }}" :selected="old('opponent_formation', $game->opponent_formation) == $formation">
                                        {{ $formation }}
                                    </flux:select.option>
                                @endforeach
                            </flux:select>
                            <flux:error name="opponent_formation" />
                        </flux:field>

                        <flux:field>
                            <flux:label>{{ __('Date') }}</flux:label>
                            <flux:date-picker name="date" value="{{ old('date', $game->date ? $game->date->format('Y-m-d') : '') }}" />
                            <flux:error name="date" />
                        </flux:field>

                        <flux:field>
                            <flux:label>{{ __('Time') }}</flux:label>
                            <flux:time-picker name="time" value="{{ old('time', $game->time) }}" />
                            <flux:error name="time" />
                        </flux:field>

                        <flux:field>
                            <flux:label>{{ __('Location') }}</flux:label>
                            <flux:input name="location" value="{{ old('location', $game->location) }}" placeholder="{{ __('Enter game location') }}" />
                            <flux:error name="location" />
                        </flux:field>
                    </div>

                    <div class="mt-6">
                        <flux:editor name="notes" label="{{ __('Notes') }}" placeholder="{{ __('Additional notes about the game') }}" :value="old('notes', $game->notes)" />
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <flux:button type="submit" variant="primary">
                            {{ __('Update Game') }}
                        </flux:button>
                    </div>
                </form>
            </flux:card>
        </div>
    </div>
</x-app-layout>

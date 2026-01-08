<div>
    <form wire:submit="save">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <flux:field>
                <flux:label>{{ __('Opponent') }}</flux:label>
                <flux:select wire:model="opponent_id" variant="listbox" placeholder="{{ __('Select opponent') }}">
                    @foreach($opponents as $opponent)
                        <flux:select.option value="{{ $opponent->id }}">{{ $opponent->name }}</flux:select.option>
                    @endforeach
                </flux:select>
                @if(count($opponents) === 0)
                    <flux:description>
                        {{ __('No opponents found.') }} <flux:link href="{{ route('opponents.create') }}">{{ __('Create one first') }}</flux:link>
                    </flux:description>
                @endif
                <flux:error name="opponent_id" />
            </flux:field>

            <flux:field>
                <flux:label>{{ __('Opponent Formation') }}</flux:label>
                <flux:select wire:model="opponent_formation" variant="listbox" placeholder="{{ __('Select formation') }}">
                    @foreach($formations as $formation)
                        <flux:select.option value="{{ $formation }}">{{ $formation }}</flux:select.option>
                    @endforeach
                </flux:select>
                <flux:error name="opponent_formation" />
            </flux:field>

            <flux:field>
                <flux:label>{{ __('Date') }}</flux:label>
                <flux:date-picker wire:model="date" />
                <flux:error name="date" />
            </flux:field>

            <flux:field>
                <flux:label>{{ __('Time') }}</flux:label>
                <flux:time-picker wire:model="time" />
                <flux:error name="time" />
            </flux:field>

            <flux:field>
                <flux:label>{{ __('Location') }}</flux:label>
                <flux:input wire:model="location" placeholder="{{ __('Enter game location') }}" />
                <flux:error name="location" />
            </flux:field>
        </div>

        <div class="mt-6">
            <flux:editor wire:model="notes" label="{{ __('Notes') }}" placeholder="{{ __('Additional notes about the game') }}" />
        </div>

        <div class="flex items-center justify-end mt-6">
            <flux:button type="submit" variant="primary">
                {{ __('Create Game') }}
            </flux:button>
        </div>
    </form>
</div>

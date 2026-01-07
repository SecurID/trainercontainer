<flux:modal name="edit-player-positions" class="md:w-xl">
    <div class="space-y-6">
        <flux:heading size="lg">{{ __('Positions of') }} {{ $player->getFullname() }}</flux:heading>

        <form wire:submit="save" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <flux:field>
                    <flux:label>{{ __('Main Position') }}</flux:label>
                    <flux:select wire:model="main_position_id" placeholder="{{ __('Select main position') }}">
                        @foreach($positions as $position)
                            <flux:select.option value="{{ $position->id }}">{{ $position->name }} ({{ $position->abbreviation }})</flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:error name="main_position_id" />
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('Sub Positions') }}</flux:label>
                    <flux:select wire:model="sub_position_ids" multiple placeholder="{{ __('Select sub positions') }}">
                        @foreach($positions as $position)
                            <flux:select.option value="{{ $position->id }}">{{ $position->name }} ({{ $position->abbreviation }})</flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:description>{{ __('Hold Ctrl/Cmd to select multiple positions') }}</flux:description>
                    <flux:error name="sub_position_ids" />
                </flux:field>
            </div>

            <div class="flex gap-2 justify-end">
                <flux:button x-on:click="$flux.modal('edit-player-positions').close()">
                    {{ __('Cancel') }}
                </flux:button>
                <flux:button type="submit" variant="primary">
                    {{ __('Save Positions') }}
                </flux:button>
            </div>
        </form>
    </div>
</flux:modal>

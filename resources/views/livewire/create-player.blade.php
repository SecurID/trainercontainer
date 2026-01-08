<form wire:submit="save">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
        <flux:field>
            <flux:label>{{ __('Pre name') }}</flux:label>
            <flux:input wire:model="prename" placeholder="{{ __('Pre name') }}" />
            <flux:error name="prename" />
        </flux:field>

        <flux:field>
            <flux:label>{{ __('Last name') }}</flux:label>
            <flux:input wire:model="lastname" placeholder="{{ __('Last name') }}" />
            <flux:error name="lastname" />
        </flux:field>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
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
            <flux:pillbox wire:model="sub_position_ids" multiple searchable placeholder="{{ __('Select sub positions...') }}">
                @foreach($positions as $position)
                    <flux:pillbox.option value="{{ $position->id }}">{{ $position->name }} ({{ $position->abbreviation }})</flux:pillbox.option>
                @endforeach
            </flux:pillbox>
            <flux:error name="sub_position_ids" />
        </flux:field>
    </div>

    <div class="flex justify-end">
        <flux:button type="submit" variant="primary">
            {{ __('Create Player') }}
        </flux:button>
    </div>
</form>

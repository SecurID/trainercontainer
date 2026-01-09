<div class="p-6 bg-white overflow-hidden sm:rounded-lg">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <flux:field>
            <flux:label>{{ __('Topic') }}</flux:label>
            <flux:input
                wire:model.live.blur="topic"
                placeholder="{{ __('Practice topic') }}"
            />
            <flux:error name="topic" />
        </flux:field>

        <flux:field>
            <flux:label>{{ __('Date') }}</flux:label>
            <flux:date-picker wire:model.live="date" />
            <flux:error name="date" />
        </flux:field>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <flux:field>
            <flux:label>{{ __('Player count') }}</flux:label>
            <flux:input
                type="number"
                wire:model.live.blur="playerCount"
                min="0"
            />
            <flux:error name="playerCount" />
        </flux:field>

        <flux:field>
            <flux:label>{{ __('Goalkeeper count') }}</flux:label>
            <flux:input
                type="number"
                wire:model.live.blur="goalkeeperCount"
                min="0"
            />
            <flux:error name="goalkeeperCount" />
        </flux:field>
    </div>

    <div class="mb-6">
        <flux:editor
            wire:model.live.debounce.500ms="notes"
            label="{{ __('Notes') }}"
            placeholder="{{ __('Practice notes and observations...') }}"
        />
    </div>
</div>

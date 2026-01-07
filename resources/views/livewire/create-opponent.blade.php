<form wire:submit="save">
    <div class="space-y-4">
        <flux:field>
            <flux:label>{{ __('Name') }}</flux:label>
            <flux:input wire:model="name" placeholder="{{ __('Name') }}" required />
            <flux:error name="name" />
        </flux:field>

        <flux:field>
            <flux:label>{{ __('Notes') }}</flux:label>
            <flux:textarea wire:model="notes" placeholder="{{ __('Notes') }}" rows="4" />
            <flux:error name="notes" />
        </flux:field>

        <div class="flex justify-end">
            <flux:button type="submit" variant="primary">
                {{ __('Create Opponent') }}
            </flux:button>
        </div>
    </div>
</form>

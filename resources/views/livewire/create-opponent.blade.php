<form wire:submit="save">
    <div class="space-y-4">
        <flux:field>
            <flux:label>{{ __('Name') }}</flux:label>
            <flux:input wire:model="name" placeholder="{{ __('Name') }}" required />
            <flux:error name="name" />
        </flux:field>

        <flux:editor wire:model="notes" label="{{ __('Notes') }}" placeholder="{{ __('Notes') }}" />

        <div class="flex justify-end">
            <flux:button type="submit" variant="primary">
                {{ __('Create Opponent') }}
            </flux:button>
        </div>
    </div>
</form>

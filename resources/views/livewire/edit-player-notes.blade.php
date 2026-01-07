<flux:modal name="edit-player-notes" class="md:w-96">
    <div class="space-y-6">
        <flux:heading size="lg">{{ __('Notes of') }} {{ $player->getFullname() }}</flux:heading>

        <form wire:submit="save" class="space-y-4">
            <flux:field>
                <flux:label>{{ __('Notes') }}</flux:label>
                <flux:textarea wire:model="notes" rows="4" />
                <flux:error name="notes" />
            </flux:field>

            <div class="flex gap-2 justify-end">
                <flux:button x-on:click="$flux.modal('edit-player-notes').close()">
                    {{ __('Cancel') }}
                </flux:button>
                <flux:button type="submit" variant="primary">
                    {{ __('Save') }}
                </flux:button>
            </div>
        </form>
    </div>
</flux:modal>

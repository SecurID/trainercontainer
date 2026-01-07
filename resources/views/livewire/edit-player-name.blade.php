<flux:modal name="edit-player-name" class="md:w-96">
    <div class="space-y-6">
        <flux:heading size="lg">{{ __('Edit Player Name') }}</flux:heading>

        <form wire:submit="save" class="space-y-4">
            <flux:field>
                <flux:label>{{ __('First Name') }}</flux:label>
                <flux:input wire:model="prename" />
                <flux:error name="prename" />
            </flux:field>

            <flux:field>
                <flux:label>{{ __('Last Name') }}</flux:label>
                <flux:input wire:model="lastname" />
                <flux:error name="lastname" />
            </flux:field>

            <div class="flex gap-2 justify-end">
                <flux:button x-on:click="$flux.modal('edit-player-name').close()">
                    {{ __('Cancel') }}
                </flux:button>
                <flux:button type="submit" variant="primary">
                    {{ __('Save') }}
                </flux:button>
            </div>
        </form>
    </div>
</flux:modal>

<div class="bg-white shadow sm:rounded-lg">
    <div class="px-4 py-5 sm:p-6">
        <flux:heading size="lg">{{ __('Update Password') }}</flux:heading>
        <flux:text class="mt-1 text-zinc-600">{{ __('Ensure your account is using a long, random password to stay secure.') }}</flux:text>

        <form wire:submit="updatePassword" class="mt-6 space-y-6">
            <flux:field>
                <flux:label>{{ __('Current Password') }}</flux:label>
                <flux:input type="password" wire:model="state.current_password" autocomplete="current-password" />
                <flux:error name="current_password" />
            </flux:field>

            <flux:field>
                <flux:label>{{ __('New Password') }}</flux:label>
                <flux:input type="password" wire:model="state.password" autocomplete="new-password" />
                <flux:error name="password" />
            </flux:field>

            <flux:field>
                <flux:label>{{ __('Confirm Password') }}</flux:label>
                <flux:input type="password" wire:model="state.password_confirmation" autocomplete="new-password" />
                <flux:error name="password_confirmation" />
            </flux:field>

            <div class="flex items-center gap-4">
                <flux:button type="submit" variant="primary">
                    {{ __('Save') }}
                </flux:button>

                <x-action-message on="saved">
                    <flux:text class="text-green-600">{{ __('Saved.') }}</flux:text>
                </x-action-message>
            </div>
        </form>
    </div>
</div>

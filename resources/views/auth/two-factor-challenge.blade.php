<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <div x-data="{ recovery: false }">
            <flux:text class="mb-4" x-show="! recovery">
                {{ __('Please confirm access to your account by entering the authentication code provided by your authenticator application.') }}
            </flux:text>

            <flux:text class="mb-4" x-show="recovery">
                {{ __('Please confirm access to your account by entering one of your emergency recovery codes.') }}
            </flux:text>

            <x-validation-errors class="mb-4" />

            <form method="POST" action="/two-factor-challenge">
                @csrf

                <div class="mt-4" x-show="! recovery">
                    <flux:field>
                        <flux:label>{{ __('Code') }}</flux:label>
                        <flux:input type="text" name="code" autofocus x-ref="code" autocomplete="one-time-code" />
                    </flux:field>
                </div>

                <div class="mt-4" x-show="recovery">
                    <flux:field>
                        <flux:label>{{ __('Recovery Code') }}</flux:label>
                        <flux:input type="text" name="recovery_code" x-ref="recovery_code" autocomplete="one-time-code" />
                    </flux:field>
                </div>

                <div class="flex items-center justify-end mt-4 gap-4">
                    <flux:button
                        variant="subtle"
                        type="button"
                        x-show="! recovery"
                        x-on:click="recovery = true; $nextTick(() => { $refs.recovery_code.focus() })"
                    >
                        {{ __('Use a recovery code') }}
                    </flux:button>

                    <flux:button
                        variant="subtle"
                        type="button"
                        x-show="recovery"
                        x-on:click="recovery = false; $nextTick(() => { $refs.code.focus() })"
                    >
                        {{ __('Use an authentication code') }}
                    </flux:button>

                    <flux:button type="submit" variant="primary">
                        {{ __('Login') }}
                    </flux:button>
                </div>
            </form>
        </div>
    </x-authentication-card>
</x-guest-layout>

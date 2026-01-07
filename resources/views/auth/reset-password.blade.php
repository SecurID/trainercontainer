<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <flux:field class="mb-4">
                <flux:label>{{ __('Email') }}</flux:label>
                <flux:input type="email" name="email" :value="old('email', $request->email)" required autofocus />
            </flux:field>

            <flux:field class="mb-4">
                <flux:label>{{ __('Password') }}</flux:label>
                <flux:input type="password" name="password" required autocomplete="new-password" />
            </flux:field>

            <flux:field class="mb-4">
                <flux:label>{{ __('Confirm Password') }}</flux:label>
                <flux:input type="password" name="password_confirmation" required autocomplete="new-password" />
            </flux:field>

            <div class="flex items-center justify-end">
                <flux:button type="submit" variant="primary">
                    {{ __('Reset Password') }}
                </flux:button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>

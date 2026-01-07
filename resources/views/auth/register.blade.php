<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <flux:field class="mb-4">
                <flux:label>{{ __('Name') }}</flux:label>
                <flux:input type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </flux:field>

            <flux:field class="mb-4">
                <flux:label>{{ __('Email') }}</flux:label>
                <flux:input type="email" name="email" :value="old('email')" required />
            </flux:field>

            <flux:field class="mb-4">
                <flux:label>{{ __('Password') }}</flux:label>
                <flux:input type="password" name="password" required autocomplete="new-password" />
            </flux:field>

            <flux:field class="mb-4">
                <flux:label>{{ __('Confirm Password') }}</flux:label>
                <flux:input type="password" name="password_confirmation" required autocomplete="new-password" />
            </flux:field>

            <flux:field class="mb-4">
                <flux:label>{{ __('Team Age') }}</flux:label>
                <flux:select name="team_age" required>
                    <flux:select.option value="u7">{{ __('U7') }}</flux:select.option>
                    <flux:select.option value="u8">{{ __('U8') }}</flux:select.option>
                    <flux:select.option value="u9">{{ __('U9') }}</flux:select.option>
                    <flux:select.option value="u10">{{ __('U10') }}</flux:select.option>
                    <flux:select.option value="u11">{{ __('U11') }}</flux:select.option>
                    <flux:select.option value="u12">{{ __('U12') }}</flux:select.option>
                    <flux:select.option value="u13">{{ __('U13') }}</flux:select.option>
                    <flux:select.option value="u14">{{ __('U14') }}</flux:select.option>
                    <flux:select.option value="u15">{{ __('U15') }}</flux:select.option>
                    <flux:select.option value="u16">{{ __('U16') }}</flux:select.option>
                    <flux:select.option value="u17">{{ __('U17') }}</flux:select.option>
                    <flux:select.option value="u19">{{ __('U19') }}</flux:select.option>
                    <flux:select.option value="adults">{{ __('Adults') }}</flux:select.option>
                </flux:select>
            </flux:field>

            <div class="flex items-center justify-end gap-4">
                <flux:link href="{{ route('login') }}" variant="subtle">
                    {{ __('Already registered?') }}
                </flux:link>

                <flux:button type="submit" variant="primary">
                    {{ __('Register') }}
                </flux:button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>

<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <flux:field class="mb-4">
                <flux:label>{{ __('Email') }}</flux:label>
                <flux:input type="email" name="email" :value="old('email')" required autofocus />
            </flux:field>

            <flux:field class="mb-4">
                <flux:label>{{ __('Password') }}</flux:label>
                <flux:input type="password" name="password" required autocomplete="current-password" />
            </flux:field>

            <div class="block mb-4">
                <flux:checkbox name="remember" label="{{ __('Remember me') }}" />
            </div>

            <div class="flex items-center justify-end gap-4">
                @if (Route::has('password.request'))
                    <flux:link href="{{ route('password.request') }}" variant="subtle">
                        {{ __('Forgot your password?') }}
                    </flux:link>
                @endif

                <flux:button type="submit" variant="primary">
                    {{ __('Login') }}
                </flux:button>
            </div>
        </form>

        <div class="flex items-center justify-end mt-4">
            <flux:button href="{{ route('register') }}" variant="subtle">
                {{ __('No Account yet? Create one!') }}
            </flux:button>
        </div>
    </x-authentication-card>
</x-guest-layout>

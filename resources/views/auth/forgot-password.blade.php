<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <flux:text class="mb-4">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </flux:text>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <flux:field class="mb-4">
                <flux:label>{{ __('Email') }}</flux:label>
                <flux:input type="email" name="email" :value="old('email')" required autofocus />
            </flux:field>

            <div class="flex items-center justify-end">
                <flux:button type="submit" variant="primary">
                    {{ __('Email Password Reset Link') }}
                </flux:button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>

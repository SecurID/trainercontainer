<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <flux:text class="mb-4">
            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
        </flux:text>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
        @endif

        <div class="mt-4 flex items-center justify-between">
            <form method="POST" action="/email/verification-notification">
                @csrf

                <flux:button type="submit" variant="primary">
                    {{ __('Resend Verification Email') }}
                </flux:button>
            </form>

            <form method="POST" action="/logout">
                @csrf

                <flux:button type="submit" variant="subtle">
                    {{ __('Logout') }}
                </flux:button>
            </form>
        </div>
    </x-authentication-card>
</x-guest-layout>

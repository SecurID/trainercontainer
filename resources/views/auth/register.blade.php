<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-label value="{{__('Name')}}" />
                <x-input class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <x-label value="{{__('Email')}}" />
                <x-input class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>

            <div class="mt-4">
                <x-label value="{{__('Password')}}" />
                <x-input class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-label value="{{__('Confirm Password')}}" />
                <x-input class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-label value="{{__('Team Age')}}" />
                <select class="block mt-1 form-input rounded-md shadow-sm w-full text-gray-500" name="team_age" required>
                    <option value="u7">{{ __('U7') }}</option>
                    <option value="u8">{{ __('U8') }}</option>
                    <option value="u9">{{ __('U9') }}</option>
                    <option value="u10">{{ __('U10') }}</option>
                    <option value="u11">{{ __('U11') }}</option>
                    <option value="u12">{{ __('U12') }}</option>
                    <option value="u13">{{ __('U13') }}</option>
                    <option value="u14">{{ __('U14') }}</option>
                    <option value="u15">{{ __('U15') }}</option>
                    <option value="u16">{{ __('U16') }}</option>
                    <option value="u17">{{ __('U17') }}</option>
                    <option value="u19">{{ __('U19') }}</option>
                    <option value="adults">{{ __('Adults') }}</option>
                </select>
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>

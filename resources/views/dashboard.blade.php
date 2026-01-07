<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap">
            <div class="w-full">
                <flux:heading size="xl">
                    {{ __('Dashboard') }}
                </flux:heading>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                <flux:heading size="lg" class="mb-4">{{ __('Next Practice') }}</flux:heading>
                @if(!$nextPractice)
                    <flux:text class="text-zinc-600">{{ __('No upcoming practices scheduled.') }}</flux:text>
                @else
                    <flux:link href="{{ route('practices.show', $nextPractice) }}">
                        {{ $nextPractice->date->format('d.m.Y') }} - {{ $nextPractice->topic }}
                    </flux:link>
                @endif
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                <flux:heading size="lg" class="mb-4">{{ __('Common actions') }}</flux:heading>
                <div class="flex flex-wrap gap-2">
                    <flux:button href="{{ route('players.create') }}" variant="primary">
                        {{ __('Create Player') }}
                    </flux:button>
                    <flux:button href="{{ route('exercises.create') }}" variant="primary">
                        {{ __('Create Exercise') }}
                    </flux:button>
                    <flux:button href="{{ route('practices.create') }}" variant="primary">
                        {{ __('Create Practice') }}
                    </flux:button>
                </div>
            </div>

            @if(!$player OR !$exercise OR !$practice)
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                <flux:heading size="lg" class="mb-4">{{ __('Onboarding Guide') }}</flux:heading>

                <ul class="space-y-1 text-zinc-500 list-inside text-lg">
                    <li class="flex items-center">
                        <svg @class(['text-zinc-400' => ! $player, 'text-green-500' => $player, 'w-3.5', 'h-3.5', 'me-2', 'flex-shrink-0']) aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                        </svg>
                        {{ __('Create your first player') }}
                    </li>
                    <li class="flex items-center">
                        <svg @class(['text-zinc-400' => ! $exercise, 'text-green-500' => $exercise, 'w-3.5', 'h-3.5', 'me-2', 'flex-shrink-0']) aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                        </svg>
                        {{ __('Create your first exercise') }}
                    </li>
                    <li class="flex items-center">
                        <svg @class(['text-zinc-400' => ! $practice, 'text-green-500' => $practice, 'w-3.5', 'h-3.5', 'me-2', 'flex-shrink-0']) aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                        </svg>
                        {{ __('Create your first practice') }}
                    </li>
                </ul>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <flux:heading size="xl">
            {{ __('Dashboard') }}
        </flux:heading>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Next Practice -->
            <flux:card>
                <flux:heading size="lg" class="mb-4">{{ __('Next Practice') }}</flux:heading>
                @if(!$nextPractice)
                    <flux:text class="text-zinc-500">{{ __('No upcoming practices scheduled.') }}</flux:text>
                @else
                    <div class="flex items-center gap-3">
                        <flux:icon.calendar class="size-5 text-zinc-400" />
                        <flux:link href="{{ route('practices.show', $nextPractice) }}">
                            {{ $nextPractice->date->format('d.m.Y') }} - {{ $nextPractice->topic }}
                        </flux:link>
                    </div>
                @endif
            </flux:card>

            <!-- Common Actions -->
            <flux:card>
                <flux:heading size="lg" class="mb-4">{{ __('Common actions') }}</flux:heading>
                <div class="flex flex-wrap gap-2">
                    <flux:button href="{{ route('players.create') }}" variant="primary" icon="user-plus">
                        {{ __('Create Player') }}
                    </flux:button>
                    <flux:button href="{{ route('exercises.create') }}" variant="primary" icon="clipboard-document-list">
                        {{ __('Create Exercise') }}
                    </flux:button>
                    <flux:button href="{{ route('practices.create') }}" variant="primary" icon="calendar-days">
                        {{ __('Create Practice') }}
                    </flux:button>
                </div>
            </flux:card>

            <!-- Onboarding Guide -->
            @if(!$player OR !$exercise OR !$practice)
                <flux:card>
                    <flux:heading size="lg" class="mb-4">{{ __('Onboarding Guide') }}</flux:heading>

                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            @if($player)
                                <flux:icon.check-circle variant="solid" class="size-5 text-green-500" />
                                <flux:text class="text-zinc-600 dark:text-zinc-400">{{ __('Create your first player') }}</flux:text>
                            @else
                                <flux:icon.check-circle class="size-5 text-zinc-300 dark:text-zinc-600" />
                                <flux:link href="{{ route('players.create') }}">{{ __('Create your first player') }}</flux:link>
                            @endif
                        </div>

                        <div class="flex items-center gap-3">
                            @if($exercise)
                                <flux:icon.check-circle variant="solid" class="size-5 text-green-500" />
                                <flux:text class="text-zinc-600 dark:text-zinc-400">{{ __('Create your first exercise') }}</flux:text>
                            @else
                                <flux:icon.check-circle class="size-5 text-zinc-300 dark:text-zinc-600" />
                                <flux:link href="{{ route('exercises.create') }}">{{ __('Create your first exercise') }}</flux:link>
                            @endif
                        </div>

                        <div class="flex items-center gap-3">
                            @if($practice)
                                <flux:icon.check-circle variant="solid" class="size-5 text-green-500" />
                                <flux:text class="text-zinc-600 dark:text-zinc-400">{{ __('Create your first practice') }}</flux:text>
                            @else
                                <flux:icon.check-circle class="size-5 text-zinc-300 dark:text-zinc-600" />
                                <flux:link href="{{ route('practices.create') }}">{{ __('Create your first practice') }}</flux:link>
                            @endif
                        </div>
                    </div>
                </flux:card>
            @endif
        </div>
    </div>
</x-app-layout>

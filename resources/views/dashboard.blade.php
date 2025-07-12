<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap">
            <div class="w-full">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Dashboard') }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                <p class="font-semibold text-xl text-gray-800 leading-tight mb-4">{{ __('Next Practice')}}</p>
                @if(!$nextPractice)
                    <p class="text-gray-500">{{ __('No upcoming practices scheduled.') }}</p>
                @else
                <a href="{{ route('practices.show', $nextPractice) }}">{{ $nextPractice->date->format('d.m.Y') }} - {{ $nextPractice->topic }}</a>
                @endif
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                <p class="font-semibold text-xl text-gray-800 leading-tight mb-4">{{ __('Common actions')}}</p>
                <div class="grid lg:grid-cols-4 grid-cols-1 lg:space-x-2 lg:space-y-0">
                    <a href="{{ route('players.create') }}"><x-button class="mb-2">{{__('Create Player')}}</x-button></a>
                    <a href="{{ route('exercises.create') }}"><x-button class="mb-2">{{__('Create Exercise')}}</x-button></a>
                    <a href="{{ route('practices.create') }}"><x-button class="mb-2">{{__('Create Practice')}}</x-button></a>
                </div>
            </div>

            @if(!$player OR !$exercise OR !$practice)
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                <p class="font-semibold text-xl text-gray-800 leading-tight mb-4">{{ __('Onboarding Guide')}}</p>

                <ul class="space-y-1 text-gray-500 list-inside text-lg dark:text-gray-400">
                    <li class="flex items-center">
                        <svg @class(['text-gray-500' => ! $player, 'text-green-500' => $player, 'w-3.5', 'h-3.5', 'me-2', 'flex-shrink-0']) aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                        </svg>
                        {{ __('Create your first player') }}
                    </li>
                    <li class="flex items-center">
                        <svg @class(['text-gray-500' => ! $exercise, 'text-green-500' => $exercise, 'w-3.5', 'h-3.5', 'me-2', 'flex-shrink-0']) aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                        </svg>
                        {{ __('Create your first exercise') }}
                    </li>
                    <li class="flex items-center">
                        <svg @class(['text-gray-500' => ! $practice, 'text-green-500' => $practice, 'w-3.5', 'h-3.5', 'me-2', 'flex-shrink-0']) aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
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

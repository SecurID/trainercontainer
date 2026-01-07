<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <flux:heading size="xl">
                {{ __('Exercises') }}
            </flux:heading>
            <div>
                <flux:button href="/exercises/create" variant="primary">
                    {{ __('Create Exercise') }}
                </flux:button>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <livewire:exercises-filter></livewire:exercises-filter>
            </div>
        </div>
    </div>
</x-app-layout>

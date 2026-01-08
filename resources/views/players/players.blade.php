<x-app-layout>
    <x-slot name="header">
        <div class="lg:flex sm:space-y-2 justify-between items-center block">
            <flux:heading size="xl">
                {{ __('Players') }}
            </flux:heading>
            <div class="flex gap-2">
                <flux:button href="{{ route('players.position-analysis') }}" variant="subtle" icon="chart-bar">
                    {{ __('Position Analysis') }}
                </flux:button>
                <flux:button href="{{ route('players.create') }}" variant="primary" icon="user-plus">
                    {{ __('Create Player') }}
                </flux:button>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <flux:card>
                <livewire:players-list />
            </flux:card>
        </div>
    </div>
</x-app-layout>

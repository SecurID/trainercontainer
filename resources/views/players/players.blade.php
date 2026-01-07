<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <flux:heading size="xl">
                {{ __('Players') }}
            </flux:heading>
            <div class="flex gap-2">
                <flux:button href="{{ route('players.position-analysis') }}" variant="subtle">
                    {{ __('Position Analysis') }}
                </flux:button>
                <flux:button href="/players/create" variant="primary">
                    {{ __('Create Player') }}
                </flux:button>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-4">
                    <livewire:players-list />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

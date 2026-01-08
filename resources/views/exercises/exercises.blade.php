<x-app-layout>
    <x-slot name="header">
        <div class="lg:flex sm:space-y-2 justify-between items-center block">
            <flux:heading size="xl">
                {{ __('Exercises') }}
            </flux:heading>
            <div class="flex gap-2">
                <flux:button href="{{ route('exercises.create') }}" variant="primary" icon="plus">
                    {{ __('Create Exercise') }}
                </flux:button>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <flux:card>
                <livewire:exercises-filter />
            </flux:card>
        </div>
    </div>
</x-app-layout>

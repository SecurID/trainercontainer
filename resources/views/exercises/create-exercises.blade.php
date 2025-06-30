<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <x-back-button></x-back-button>
            <h2 class="text-xl font-semibold text-gray-800 leading-tight">
                {{ __('Create Exercise') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <livewire:create-exercise />
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Exercises') }}
            </h2>
            <div>
                <a href="/exercises/create">
                    <button class="px-4 py-2 text-white bg-blue-500 hover:bg-blue-700 rounded">
                        {{ __('Create Exercise') }}
                    </button>
                </a>
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

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Create Practice') }}
            </h2>
        </div>
    </x-slot>
    <div class="py-12">
        <livewire:create-recurring-practice />
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <x-back-button></x-back-button>
            <h2 class="ml-2 text-xl font-semibold leading-tight text-gray-800">
                {{ __('Edit Opponent') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form action="{{ route('opponents.update', $opponent->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-label for="name" value="{{ __('Name') }}" />
                        <x-input id="name" class="block mt-1 w-full" type="text" name="name"
                                value="{{ old('name', $opponent->name) }}" required />
                        @error('name')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mt-6">
                        <x-label for="notes" value="{{ __('Notes') }}" />
                        <textarea id="notes" name="notes" rows="4"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('notes', $opponent->notes) }}</textarea>
                        @error('notes')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <x-button class="ml-4">
                            {{ __('Update Opponent') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

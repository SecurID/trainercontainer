<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <x-back-button></x-back-button>
            <h2 class="ml-2 text-xl font-semibold leading-tight text-gray-800">
                {{ __('Edit Game') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form action="{{ route('games.update', $game->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-label for="opponent" value="{{ __('Opponent') }}" />
                            <x-input id="opponent" class="block mt-1 w-full" type="text" name="opponent" 
                                    value="{{ old('opponent', $game->opponent) }}" required />
                            @error('opponent')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <x-label for="date" value="{{ __('Date') }}" />
                            <x-input id="date" class="block mt-1 w-full" type="date" name="date" 
                                    value="{{ old('date', $game->date ? $game->date->format('Y-m-d') : '') }}" required />
                            @error('date')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <x-label for="time" value="{{ __('Time') }}" />
                            <x-input id="time" class="block mt-1 w-full" type="time" name="time" 
                                    value="{{ old('time', $game->time) }}" />
                            @error('time')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <x-label for="location" value="{{ __('Location') }}" />
                            <x-input id="location" class="block mt-1 w-full" type="text" name="location" 
                                    value="{{ old('location', $game->location) }}" />
                            @error('location')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-6">
                        <x-label for="notes" value="{{ __('Notes') }}" />
                        <textarea id="notes" name="notes" rows="4" 
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('notes', $game->notes) }}</textarea>
                        @error('notes')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <x-button class="ml-4">
                            {{ __('Update Game') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
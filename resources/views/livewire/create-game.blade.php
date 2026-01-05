<div>
    <form wire:submit="save">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <x-label for="opponent_id" value="{{ __('Opponent') }}" />
                <select id="opponent_id" wire:model="opponent_id"
                        class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        required>
                    <option value="">{{ __('Select opponent') }}</option>
                    @foreach($opponents as $opponent)
                        <option value="{{ $opponent->id }}">{{ $opponent->name }}</option>
                    @endforeach
                </select>
                @if(count($opponents) === 0)
                    <p class="text-sm text-gray-600 mt-1">
                        {{ __('No opponents found.') }} <a href="{{ route('opponents.create') }}" class="text-primary-600 hover:text-primary-800">{{ __('Create one first') }}</a>
                    </p>
                @endif
                @error('opponent_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <x-label for="opponent_formation" value="{{ __('Opponent Formation') }}" />
                <select id="opponent_formation" wire:model="opponent_formation"
                        class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    <option value="">{{ __('Select formation') }}</option>
                    @foreach($formations as $formation)
                        <option value="{{ $formation }}">{{ $formation }}</option>
                    @endforeach
                </select>
                @error('opponent_formation')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <x-label for="date" value="{{ __('Date') }}" />
                <x-input id="date" class="block mt-1 w-full" type="date" wire:model="date" required />
                @error('date')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <x-label for="time" value="{{ __('Time') }}" />
                <x-input id="time" class="block mt-1 w-full" type="time" wire:model="time" />
                @error('time')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <x-label for="location" value="{{ __('Location') }}" />
                <x-input id="location" class="block mt-1 w-full" type="text" wire:model="location" 
                        placeholder="{{ __('Enter game location') }}" />
                @error('location')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="mt-6">
            <x-label for="notes" value="{{ __('Notes') }}" />
            <textarea id="notes" wire:model="notes" rows="4" 
                    placeholder="{{ __('Additional notes about the game') }}"
                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"></textarea>
            @error('notes')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex items-center justify-end mt-6">
            <x-button class="ml-4">
                {{ __('Create Game') }}
            </x-button>
        </div>

        @if (session()->has('success-message'))
            <div class="mt-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success-message') }}
            </div>
        @endif
    </form>
</div>
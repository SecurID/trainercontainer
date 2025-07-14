<div>
    <form wire:submit.prevent="create">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="grid grid-cols-2 gap-4 mb-4 justify-between">
                    <div>
                        <label for="start_date" class="text-sm font-bold text-gray-700">Startdatum</label>
                        <input type="date" id="start_date" wire:model="start_date" class="w-full px-3 py-2 border border-gray-300 rounded-md" />
                        @error('start_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="end_date" class="text-sm font-bold text-gray-700">Enddatum</label>
                        <input type="date" id="end_date" wire:model="end_date" class="w-full px-3 py-2 border border-gray-300 rounded-md" />
                        @error('end_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 mb-4 justify-between">
                    <div>
                        <label class="text-sm font-bold text-gray-700">Wochentage</label>
                        <div class="flex space-x-4 mt-2">
                            <label class="inline-flex items-center">
                                <input type="checkbox" value="1" wire:model="weekdays" class="form-checkbox text-blue-600" />
                                <span class="ml-2">Montag</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" value="2" wire:model="weekdays" class="form-checkbox text-blue-600" />
                                <span class="ml-2">Dienstag</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" value="3" wire:model="weekdays" class="form-checkbox text-blue-600" />
                                <span class="ml-2">Mittwoch</span>
                            </label>
                        </div>
                        <div class="flex space-x-4 mt-2">
                            <label class="inline-flex items-center">
                                <input type="checkbox" value="4" wire:model="weekdays" class="form-checkbox text-blue-600" />
                                <span class="ml-2">Donnerstag</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" value="5" wire:model="weekdays" class="form-checkbox text-blue-600" />
                                <span class="ml-2">Freitag</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" value="6" wire:model="weekdays" class="form-checkbox text-blue-600" />
                                <span class="ml-2">Samstag</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" value="7" wire:model="weekdays" class="form-checkbox text-blue-600" />
                                <span class="ml-2">Sonntag</span>
                            </label>
                        </div>
                        @error('weekdays') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="time" class="text-sm font-bold text-gray-700">Uhrzeit</label>
                        <input type="time" id="time" wire:model="time" class="w-full px-3 py-2 border border-gray-300 rounded-md" />
                        @error('time') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="flex justify-end mt-4">
                    <x-button type="submit">
                        Erstellen
                    </x-button>
                </div>
                @if($success)
                    <div class="mt-4 text-green-600 font-semibold">Trainingseinheiten wurden erfolgreich erstellt!</div>
                @endif
            </div>
        </div>
    </form>
</div>

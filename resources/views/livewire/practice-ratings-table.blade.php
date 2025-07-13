<div>
    <div class="mb-4 flex items-center justify-between">
        <button wire:click="toggleCollapse"
                class="flex w-full justify-between space-x-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors duration-200">
            <h2 class="text-xl font-bold text-gray-800">Spielerbewertungen</h2>
            <div class="flex items-center space-x-2">
                <span class="text-sm font-medium">
                    {{ $isCollapsed ? 'Anzeigen' : 'Ausblenden' }}
                </span>
                <svg class="w-4 h-4 transform transition-transform duration-200 {{ $isCollapsed ? 'rotate-180' : '' }}"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </div>
        </button>
    </div>

    <!-- Collapsible Content -->
    <div class="transition-all duration-300 ease-in-out {{ $isCollapsed ? 'max-h-0 overflow-hidden opacity-0' : 'max-h-none opacity-100' }}">
        <!-- Desktop Table View -->
        <div class="hidden md:block">
        <table class="w-full table-auto">
            <thead>
            <tr class="text-center text-white bg-gray-800">
                <th class="px-4 py-2">#</th>
                <th class="px-4 py-2">Name</th>
                <th class="px-4 py-2">Bewertung</th>
            </tr>
            </thead>
            <tbody>
            @foreach($players as $index => $player)
                <tr>
                    <td class="px-4 py-2 text-center">{{ $index + 1 }}</td>
                    <td class="px-4 py-2">{{ $player->getFullname() }}</td>
                    <td class="px-4 py-2 text-center">
                        <div class="grid grid-cols-2 items-center space-y-1">
                            <div class="flex items-center space-x-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <label>
                                        <input type="radio" wire:model="ratings.{{ $player->id }}" value="{{ $i }}" @if(isset($attendances[$player->id]) && $attendances[$player->id] === true) disabled @endif>
                                        <span>{{ $i }}</span>
                                    </label>
                                @endfor
                            </div>
                            <label class="flex items-center space-x-1 mt-1">
                                <input type="checkbox" wire:model="attendances.{{ $player->id }}" value="1"
                                    x-on:change="if($event.target.checked){ $wire.set('ratings.{{ $player->id }}', null) }">
                                <span>Nicht anwesend</span>
                            </label>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <!-- Mobile Card View -->
    <div class="md:hidden space-y-4">
        @foreach($players as $index => $player)
            <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-lg font-semibold text-gray-800">{{ $player->getFullname() }}</h3>
                    <span class="text-sm text-gray-500">#{{ $index + 1 }}</span>
                </div>

                <!-- Attendance Checkbox -->
                <div class="mb-4">
                    <label class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg cursor-pointer hover:bg-gray-100">
                        <input type="checkbox" wire:model="attendances.{{ $player->id }}" value="1"
                            class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                            x-on:change="if($event.target.checked){ $wire.set('ratings.{{ $player->id }}', null) }">
                        <span class="text-gray-700 font-medium">Nicht anwesend</span>
                    </label>
                </div>

                <!-- Rating Buttons -->
                <div class="space-y-2">
                    <div class="text-sm font-medium text-gray-700 mb-2">Bewertung:</div>
                    <div class="grid grid-cols-5 gap-2">
                        @for($i = 1; $i <= 5; $i++)
                            <label class="cursor-pointer">
                                <input type="radio" wire:model="ratings.{{ $player->id }}" value="{{ $i }}"
                                    class="sr-only" @if(isset($attendances[$player->id]) && $attendances[$player->id] === true) disabled @endif>
                                <div class="flex items-center justify-center h-12 w-full border-2 rounded-lg transition-all duration-200
                                    {{ (isset($ratings[$player->id]) && $ratings[$player->id] == $i) ? 'border-blue-500 bg-blue-500 text-white' : 'border-gray-300 bg-white text-gray-700 hover:border-blue-300 hover:bg-blue-50' }}
                                    {{ (isset($attendances[$player->id]) && $attendances[$player->id] === true) ? 'opacity-50 cursor-not-allowed' : '' }}">
                                    <span class="text-lg font-semibold">{{ $i }}</span>
                                </div>
                            </label>
                        @endfor
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-6">
        @if($success)
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg text-center">
                Bewertungen wurden erfolgreich gespeichert!
            </div>
        @endif
        <button wire:click="saveRatings"
                class="w-full px-6 py-3 bg-blue-600 text-white text-lg font-semibold rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 transition-colors duration-200">
            Bewertungen speichern
        </button>
    </div>
    </div>
</div>

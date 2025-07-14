<div>
    <div class="mt-4 flex items-center justify-between">
        <button wire:click="toggleCollapse"
                class="flex w-full justify-between space-x-2 px-4 py-2 bg-bg-secondary hover:bg-bg-tertiary rounded-lg transition-colors duration-200">
            <h2 class="text-xl font-bold text-text-primary">Spieler:innenbewertungen</h2>
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
        <!-- Unified Responsive Player Cards -->
        <div class="mt-4 space-y-3">
            @foreach($players as $index => $player)
                <div class="bg-bg-primary border border-border-light rounded-lg p-4 shadow-sm hover:shadow-md transition-shadow">
                    <!-- Player Header -->
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-4 gap-2">
                        <div class="flex items-center space-x-3">
                            <span class="flex-shrink-0 w-8 h-8 bg-bg-secondary rounded-full flex items-center justify-center text-sm font-semibold text-text-secondary">
                                {{ $index + 1 }}
                            </span>
                            <h3 class="text-lg font-semibold text-text-primary">{{ $player->getFullnameLastFirst() }}</h3>
                        </div>

                        <!-- Not Attended Checkbox -->
                        <div class="flex-shrink-0">
                            <label class="flex items-center space-x-2 p-2 bg-bg-secondary rounded-lg cursor-pointer hover:bg-bg-tertiary transition-colors">
                                <input type="checkbox"
                                       wire:model.live="attendances.{{ $player->id }}"
                                       value="1"
                                       class="w-4 h-4 text-error-red border-border-default rounded focus:ring-error-red">
                                <span class="text-sm font-medium text-text-primary">Nicht anwesend</span>
                            </label>
                        </div>
                    </div>

                    <!-- Rating Section -->
                    <div class="space-y-3">
                        <div class="text-sm font-medium text-text-primary">Bewertung:</div>
                        <div class="grid grid-cols-5 gap-2 sm:gap-3">
                            @for($i = 1; $i <= 5; $i++)
                                <label class="cursor-pointer group">
                                    <input type="radio"
                                           wire:model.live="ratings.{{ $player->id }}"
                                           value="{{ $i }}"
                                           class="sr-only"
                                           @if(isset($attendances[$player->id]) && $attendances[$player->id] === true) disabled @endif>
                                    <div class="flex items-center justify-center h-12 sm:h-10 lg:h-8 w-full border-2 rounded-lg transition-all duration-200 text-center
                                        {{ (isset($ratings[$player->id]) && $ratings[$player->id] == $i) ? 'border-primary-500 bg-primary-500 text-text-inverse shadow-md' : 'border-border-default bg-bg-primary text-text-primary' }}
                                        {{ (isset($attendances[$player->id]) && $attendances[$player->id] === true) ? 'opacity-40 cursor-not-allowed' : 'hover:border-primary-400 hover:bg-primary-50 group-hover:scale-105' }}">
                                        <span class="text-lg sm:text-base lg:text-sm font-bold">{{ $i }}</span>
                                    </div>
                                </label>
                            @endfor
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Save Section -->
        <div class="mt-6 space-y-4">
            @if($success)
                <div class="p-4 bg-primary-100 text-primary-800 rounded-lg text-center border border-primary-200">
                    <div class="flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-medium">Bewertungen wurden erfolgreich gespeichert!</span>
                    </div>
                </div>
            @endif

            <button wire:click="saveRatings"
                    class="w-full px-6 py-4 bg-primary-500 text-text-inverse text-lg font-semibold rounded-lg hover:bg-primary-600 focus:outline-none focus:ring-4 focus:ring-primary-300 transition-all duration-200 shadow-md hover:shadow-lg">
                <div class="flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>Bewertungen speichern</span>
                </div>
            </button>
        </div>
    </div>
</div>

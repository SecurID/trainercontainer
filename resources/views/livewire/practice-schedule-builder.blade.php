<div>
    <div class="flex items-center justify-between">
        <button wire:click="toggleCollapse"
                class="flex w-full justify-between space-x-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors duration-200">
            <h2 class="text-xl font-bold text-gray-800">Trainingsablauf</h2>
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
    <div class="mt-4 transition-all duration-300 ease-in-out {{ $isCollapsed ? 'max-h-0 overflow-hidden opacity-0' : 'max-h-none opacity-100' }}">

        <!-- Success Message -->
        @if($successMessage)
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded-lg text-sm font-medium animate-pulse">
                {{ $successMessage }}
            </div>
        @endif

        <!-- Desktop Table View -->
        <div class="hidden lg:block">
            <div class="overflow-x-auto">
                <table class="w-full table-auto border-collapse">
                    <thead>
                        <tr class="text-center text-white bg-gray-800">
                            <th class="px-4 py-3 w-10">#</th>
                            <th class="px-4 py-3 text-left min-w-[200px]">Übung</th>
                            <th class="px-4 py-3 w-20">Spieler:innen</th>
                            <th class="px-4 py-3 w-20">Torhüter:innen</th>
                            <th class="px-4 py-3 w-36">Zeit</th>
                            <th class="px-4 py-3 min-w-[80px]">Trainer:in</th>
                            <th class="px-4 py-3 w-16">Aktion</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($scheduleRows as $index => $row)
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    {{ $index+1 }}
                                </td>
                                <!-- Exercise Autocomplete -->
                                <td class="px-4 py-3 relative">
                                    <input type="text"
                                           wire:model.live="exerciseSearchTerms.{{ $index }}"
                                           wire:focus="showExerciseDropdown({{ $index }})"
                                           placeholder="Übung suchen..."
                                           id="exercise-input-{{ $index }}"
                                           class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                                </td>

                                <!-- Player Count -->
                                <td class="px-4 py-3">
                                    <input type="number"
                                           wire:model.live="scheduleRows.{{ $index }}.playerCount"
                                           min="1" max="30"
                                           class="w-full border rounded px-2 py-2 text-center focus:outline-none focus:ring-2 focus:ring-blue-400">
                                </td>

                                <!-- Goalkeeper Count -->
                                <td class="px-4 py-3">
                                    <input type="number"
                                           wire:model.live="scheduleRows.{{ $index }}.goalkeeperCount"
                                           min="0" max="5"
                                           class="w-full border rounded px-2 py-2 text-center focus:outline-none focus:ring-2 focus:ring-blue-400">
                                </td>

                                <!-- Time -->
                                <td class="px-4 py-3">
                                    <input type="text"
                                           wire:model.live="scheduleRows.{{ $index }}.time"
                                           placeholder="z.B. 10 min"
                                           class="w-full border rounded px-2 py-2 text-center focus:outline-none focus:ring-2 focus:ring-blue-400">
                                </td>

                                <!-- Coaches -->
                                <td class="px-4 py-3">
                                    <input type="text"
                                           wire:model.live="scheduleRows.{{ $index }}.coaches"
                                           placeholder="Trainer"
                                           class="w-full border rounded px-2 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                                </td>

                                <!-- Actions -->
                                <td class="px-4 py-3 text-center">
                                    <button wire:click="removeRow({{ $index }})"
                                            class="text-red-600 hover:text-red-800 hover:bg-red-50 p-1 rounded">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Exercise Dropdown Portal (outside table) -->
        @foreach($scheduleRows as $index => $row)
            @if(isset($showExerciseDropdowns[$index]) && $showExerciseDropdowns[$index])
                <div id="exercise-dropdown-{{ $index }}"
                     class="fixed z-[9999] bg-white border border-gray-300 rounded-lg shadow-2xl max-h-40 overflow-y-auto min-w-[300px]"
                     x-data="{ positioned: false }"
                     x-init="
                         $nextTick(() => {
                             if (!positioned) {
                                 const input = document.getElementById('exercise-input-{{ $index }}');
                                 if (input) {
                                     const rect = input.getBoundingClientRect();
                                     $el.style.top = (rect.bottom + window.scrollY + 4) + 'px';
                                     $el.style.left = rect.left + 'px';
                                     $el.style.width = Math.max(rect.width, 300) + 'px';
                                     positioned = true;
                                 }
                             }
                         })
                     ">
                    @if(isset($availableExercises[$index]) && count($availableExercises[$index]) > 0)
                        @foreach($availableExercises[$index] as $exercise)
                            <div wire:click="selectExercise({{ $index }}, {{ $exercise->id }})"
                                 class="px-4 py-2 hover:bg-blue-50 cursor-pointer border-b border-gray-100 last:border-b-0">
                                <div class="font-medium text-gray-900">{{ $exercise->name }}</div>
                                @if($exercise->focus)
                                    <div class="text-sm text-gray-600">{{ $exercise->focus }}</div>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <div class="px-4 py-2 text-gray-500 text-sm">
                            Keine Übungen gefunden
                        </div>
                    @endif
                </div>
            @endif
        @endforeach

        <!-- Mobile Card View -->
        <div class="lg:hidden space-y-4">
            @foreach($scheduleRows as $index => $row)
                <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Übung {{ $index + 1 }}</h3>
                        <button wire:click="removeRow({{ $index }})"
                                class="text-red-600 hover:text-red-800 hover:bg-red-50 p-2 rounded">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Exercise Search -->
                    <div class="mb-4 relative">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Übung</label>
                        <input type="text"
                               wire:model.live="exerciseSearchTerms.{{ $index }}"
                               wire:focus="showExerciseDropdown({{ $index }})"
                               placeholder="Übung suchen..."
                               id="exercise-input-{{ $index }}"
                               class="w-full border rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>

                    <!-- Player and Goalkeeper Counts -->
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Spieler:innen</label>
                            <input type="number"
                                   wire:model.live="scheduleRows.{{ $index }}.playerCount"
                                   min="1" max="30"
                                   class="w-full border rounded-lg px-4 py-3 text-center focus:outline-none focus:ring-2 focus:ring-blue-400">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Torwart</label>
                            <input type="number"
                                   wire:model.live="scheduleRows.{{ $index }}.goalkeeperCount"
                                   min="0" max="5"
                                   class="w-full border rounded-lg px-4 py-3 text-center focus:outline-none focus:ring-2 focus:ring-blue-400">
                        </div>
                    </div>

                    <!-- Time and Coaches -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Zeit</label>
                            <input type="text"
                                   wire:model.live="scheduleRows.{{ $index }}.time"
                                   placeholder="z.B. 10 min"
                                   class="w-full border rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-400">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Trainer</label>
                            <input type="text"
                                   wire:model.live="scheduleRows.{{ $index }}.coaches"
                                   placeholder="Trainer"
                                   class="w-full border rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-400">
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Add New Row Button -->
        <div class="mt-6">
            <x-button wire:click="addRow">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                <span>Übung hinzufügen</span>
            </x-button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('success-message', () => {
            setTimeout(() => {
                @this.set('successMessage', '');
            }, 2000);
        });
    });

    // Position exercise dropdowns correctly
    function positionExerciseDropdown(inputId, dropdownId) {
        const input = document.getElementById(inputId);
        const dropdown = document.getElementById(dropdownId);

        if (input && dropdown) {
            const rect = input.getBoundingClientRect();
            dropdown.style.top = (rect.bottom + window.scrollY + 2) + 'px';
            dropdown.style.left = rect.left + 'px';
            dropdown.style.width = Math.max(rect.width, 300) + 'px';
            dropdown.style.display = 'block';
        }
    }

    // Hide all exercise dropdowns
    function hideAllExerciseDropdowns() {
        document.querySelectorAll('[id^="exercise-dropdown-"]').forEach(dropdown => {
            dropdown.style.display = 'none';
        });
    }

    // Listen for Livewire updates to show/hide dropdowns
    document.addEventListener('livewire:updated', () => {
        // Position visible dropdowns
        @foreach($scheduleRows as $index => $row)
            @if(isset($showExerciseDropdowns[$index]) && $showExerciseDropdowns[$index])
                positionExerciseDropdown('exercise-input-{{ $index }}', 'exercise-dropdown-{{ $index }}');
            @endif
        @endforeach

        // Hide dropdowns that should be hidden
        @foreach($scheduleRows as $index => $row)
            @if(!isset($showExerciseDropdowns[$index]) || !$showExerciseDropdowns[$index])
                const dropdown{{ $index }} = document.getElementById('exercise-dropdown-{{ $index }}');
                if (dropdown{{ $index }}) {
                    dropdown{{ $index }}.style.display = 'none';
                }
            @endif
        @endforeach
    });

    // Hide dropdowns when clicking outside
    document.addEventListener('click', function(event) {
        if (!event.target.closest('[id^="exercise-input-"]') && !event.target.closest('[id^="exercise-dropdown-"]')) {
            hideAllExerciseDropdowns();
        }
    });
</script>

<div>
    <div class="flex items-center justify-between">
        <button wire:click="toggleCollapse"
                class="flex w-full justify-between space-x-2 px-4 py-2 bg-zinc-100 hover:bg-zinc-200 rounded-lg transition-colors duration-200">
            <flux:heading size="lg">Trainingsablauf</flux:heading>
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

    <div class="mt-4 transition-all duration-300 ease-in-out {{ $isCollapsed ? 'max-h-0 overflow-hidden opacity-0' : 'max-h-none opacity-100' }}">

        @if($successMessage)
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded-lg text-sm font-medium animate-pulse">
                {{ $successMessage }}
            </div>
        @endif

        <div class="hidden lg:block">
            <div class="overflow-x-auto">
                <table class="w-full table-auto border-collapse">
                    <thead>
                        <tr class="text-center text-white bg-zinc-800">
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
                            <tr wire:key="schedule-row-{{ $index }}" class="border-b border-zinc-200 hover:bg-zinc-50">
                                <td class="px-4 py-3">
                                    {{ $index+1 }}
                                </td>
                                <td class="px-4 py-3 relative">
                                    <flux:input
                                        wire:model.live="exerciseSearchTerms.{{ $index }}"
                                        wire:focus="showExerciseDropdown({{ $index }})"
                                        placeholder="Übung suchen..."
                                        id="exercise-input-{{ $index }}"
                                    />
                                </td>
                                <td class="px-4 py-3">
                                    <flux:input
                                        type="number"
                                        wire:model.live="scheduleRows.{{ $index }}.playerCount"
                                        min="1"
                                        max="30"
                                    />
                                </td>
                                <td class="px-4 py-3">
                                    <flux:input
                                        type="number"
                                        wire:model.live="scheduleRows.{{ $index }}.goalkeeperCount"
                                        min="0"
                                        max="5"
                                    />
                                </td>
                                <td class="px-4 py-3">
                                    <flux:input
                                        wire:model.live="scheduleRows.{{ $index }}.time"
                                        placeholder="z.B. 10 min"
                                    />
                                </td>
                                <td class="px-4 py-3">
                                    <flux:input
                                        wire:model.live="scheduleRows.{{ $index }}.coaches"
                                        placeholder="Trainer"
                                    />
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <flux:button
                                        wire:click="removeRow({{ $index }})"
                                        variant="ghost"
                                        size="sm"
                                        icon="trash"
                                        class="text-red-600 hover:text-red-800 hover:bg-red-50"
                                    />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @foreach($scheduleRows as $index => $row)
            @if(isset($showExerciseDropdowns[$index]) && $showExerciseDropdowns[$index])
                <div id="exercise-dropdown-{{ $index }}"
                     class="fixed z-[9999] bg-white border border-zinc-300 rounded-lg shadow-2xl max-h-40 overflow-y-auto min-w-[300px]"
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
                                 class="px-4 py-2 hover:bg-zinc-50 cursor-pointer border-b border-zinc-100 last:border-b-0">
                                <div class="font-medium text-zinc-900">{{ $exercise->name }}</div>
                                @if($exercise->focus)
                                    <div class="text-sm text-zinc-600">{{ $exercise->focus }}</div>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <div class="px-4 py-2 text-zinc-500 text-sm">
                            Keine Übungen gefunden
                        </div>
                    @endif
                </div>
            @endif
        @endforeach

        <div class="lg:hidden space-y-4">
            @foreach($scheduleRows as $index => $row)
                <div wire:key="mobile-schedule-row-{{ $index }}" class="bg-white border border-zinc-200 rounded-lg p-4 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <flux:heading size="base">Übung {{ $index + 1 }}</flux:heading>
                        <flux:button
                            wire:click="removeRow({{ $index }})"
                            variant="ghost"
                            size="sm"
                            icon="trash"
                            class="text-red-600 hover:text-red-800 hover:bg-red-50"
                        />
                    </div>

                    <flux:field class="mb-4">
                        <flux:label>Übung</flux:label>
                        <flux:input
                            wire:model.live="exerciseSearchTerms.{{ $index }}"
                            wire:focus="showExerciseDropdown({{ $index }})"
                            placeholder="Übung suchen..."
                            id="exercise-input-{{ $index }}"
                        />
                    </flux:field>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <flux:field>
                            <flux:label>Spieler:innen</flux:label>
                            <flux:input
                                type="number"
                                wire:model.live="scheduleRows.{{ $index }}.playerCount"
                                min="1"
                                max="30"
                            />
                        </flux:field>
                        <flux:field>
                            <flux:label>Torwart</flux:label>
                            <flux:input
                                type="number"
                                wire:model.live="scheduleRows.{{ $index }}.goalkeeperCount"
                                min="0"
                                max="5"
                            />
                        </flux:field>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <flux:field>
                            <flux:label>Zeit</flux:label>
                            <flux:input
                                wire:model.live="scheduleRows.{{ $index }}.time"
                                placeholder="z.B. 10 min"
                            />
                        </flux:field>
                        <flux:field>
                            <flux:label>Trainer</flux:label>
                            <flux:input
                                wire:model.live="scheduleRows.{{ $index }}.coaches"
                                placeholder="Trainer"
                            />
                        </flux:field>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            <flux:button wire:click="addRow" icon="plus">
                Übung hinzufügen
            </flux:button>
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

    function hideAllExerciseDropdowns() {
        document.querySelectorAll('[id^="exercise-dropdown-"]').forEach(dropdown => {
            dropdown.style.display = 'none';
        });
    }

    document.addEventListener('livewire:updated', () => {
        @foreach($scheduleRows as $index => $row)
            @if(isset($showExerciseDropdowns[$index]) && $showExerciseDropdowns[$index])
                positionExerciseDropdown('exercise-input-{{ $index }}', 'exercise-dropdown-{{ $index }}');
            @endif
        @endforeach

        @foreach($scheduleRows as $index => $row)
            @if(!isset($showExerciseDropdowns[$index]) || !$showExerciseDropdowns[$index])
                const dropdown{{ $index }} = document.getElementById('exercise-dropdown-{{ $index }}');
                if (dropdown{{ $index }}) {
                    dropdown{{ $index }}.style.display = 'none';
                }
            @endif
        @endforeach
    });

    document.addEventListener('click', function(event) {
        if (!event.target.closest('[id^="exercise-input-"]') && !event.target.closest('[id^="exercise-dropdown-"]')) {
            hideAllExerciseDropdowns();
        }
    });
</script>

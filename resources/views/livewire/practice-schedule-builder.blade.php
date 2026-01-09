<div>
    <!-- Desktop Table View -->
        <div class="hidden lg:block">
            <div class="overflow-x-auto">
                <table class="w-full table-auto border-collapse">
                    <thead>
                        <tr class="text-center text-white bg-zinc-800">
                            <th class="px-4 py-3 w-10">#</th>
                            <th class="px-4 py-3 text-left min-w-[200px]">{{ __('Exercise') }}</th>
                            <th class="px-4 py-3 w-20">{{ __('Player count') }}</th>
                            <th class="px-4 py-3 w-20">{{ __('Goalkeeper count') }}</th>
                            <th class="px-4 py-3 w-36">{{ __('Time') }}</th>
                            <th class="px-4 py-3 min-w-[80px]">{{ __('Coaches') }}</th>
                            <th class="px-4 py-3 w-16">{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($scheduleRows as $index => $row)
                            <tr wire:key="schedule-row-{{ $index }}" class="border-b border-zinc-200 hover:bg-zinc-50">
                                <td class="px-4 py-3 text-center text-sm font-medium">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-4 py-3">
                                    <flux:autocomplete
                                        wire:model.live="exerciseSearchTerms.{{ $index }}"
                                        placeholder="{{ __('Search exercise...') }}"
                                    >
                                        @foreach($this->getFilteredExercises($index) as $exercise)
                                            <flux:autocomplete.item
                                                wire:key="exercise-{{ $index }}-{{ $exercise->id }}"
                                                wire:click="selectExercise({{ $index }}, {{ $exercise->id }})"
                                            >
                                                {{ $exercise->name }}
                                            </flux:autocomplete.item>
                                        @endforeach
                                    </flux:autocomplete>
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
                                        placeholder="{{ __('e.g. 10 min') }}"
                                    />
                                </td>
                                <td class="px-4 py-3">
                                    <flux:input
                                        wire:model.live="scheduleRows.{{ $index }}.coaches"
                                        placeholder="{{ __('Coach') }}"
                                    />
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <flux:button
                                        wire:click="removeRow({{ $index }})"
                                        variant="danger"
                                        size="sm"
                                        icon="trash"
                                    />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Mobile Card View -->
        <div class="lg:hidden space-y-4">
            @foreach($scheduleRows as $index => $row)
                <div wire:key="mobile-schedule-row-{{ $index }}" class="bg-zinc-50 rounded-lg p-4 space-y-3">
                    <div class="flex items-center justify-between">
                        <flux:badge>{{ __('#') }}{{ $index + 1 }}</flux:badge>
                        <flux:button
                            wire:click="removeRow({{ $index }})"
                            variant="danger"
                            size="sm"
                            icon="trash"
                        />
                    </div>

                    <flux:field>
                        <flux:label>{{ __('Exercise') }}</flux:label>
                        <flux:autocomplete
                            wire:model.live="exerciseSearchTerms.{{ $index }}"
                            placeholder="{{ __('Search exercise...') }}"
                        >
                            @foreach($this->getFilteredExercises($index) as $exercise)
                                <flux:autocomplete.item
                                    wire:key="mobile-exercise-{{ $index }}-{{ $exercise->id }}"
                                    wire:click="selectExercise({{ $index }}, {{ $exercise->id }})"
                                >
                                    {{ $exercise->name }}
                                </flux:autocomplete.item>
                            @endforeach
                        </flux:autocomplete>
                    </flux:field>

                    <div class="grid grid-cols-2 gap-3">
                        <flux:field>
                            <flux:label>{{ __('Player count') }}</flux:label>
                            <flux:input
                                type="number"
                                wire:model.live="scheduleRows.{{ $index }}.playerCount"
                                min="1"
                                max="30"
                            />
                        </flux:field>
                        <flux:field>
                            <flux:label>{{ __('Goalkeeper count') }}</flux:label>
                            <flux:input
                                type="number"
                                wire:model.live="scheduleRows.{{ $index }}.goalkeeperCount"
                                min="0"
                                max="5"
                            />
                        </flux:field>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <flux:field>
                            <flux:label>{{ __('Time') }}</flux:label>
                            <flux:input
                                wire:model.live="scheduleRows.{{ $index }}.time"
                                placeholder="{{ __('e.g. 10 min') }}"
                            />
                        </flux:field>
                        <flux:field>
                            <flux:label>{{ __('Coaches') }}</flux:label>
                            <flux:input
                                wire:model.live="scheduleRows.{{ $index }}.coaches"
                                placeholder="{{ __('Coach') }}"
                            />
                        </flux:field>
                    </div>
                </div>
            @endforeach
        </div>

    <div class="mt-6">
        <flux:button wire:click="addRow" icon="plus">
            {{ __('Add exercise') }}
        </flux:button>
    </div>
</div>

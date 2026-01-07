<div>
    <form wire:submit="save">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <flux:field>
                        <flux:label>{{ __('Datum') }}</flux:label>
                        <flux:input type="date" wire:model="date" />
                        <flux:error name="date" />
                    </flux:field>

                    <flux:field>
                        <flux:label>{{ __('Topic') }}</flux:label>
                        <flux:input wire:model="topic" placeholder="{{ __('1 on 1') }}" />
                        <flux:error name="topic" />
                    </flux:field>
                </div>

                <div>
                    <flux:heading size="lg" class="py-4 text-center">{{ __('Schedule') }}</flux:heading>

                    <!-- Desktop Table View -->
                    <div class="hidden md:block overflow-x-auto">
                        <table class="w-full table-auto">
                            <thead>
                                <tr class="text-center text-white bg-zinc-800">
                                    <th class="px-4 py-2">{{ __('#') }}</th>
                                    <th class="px-4 py-2">{{ __('Exercise') }}</th>
                                    <th class="px-4 py-2">{{ __('Coaches') }}</th>
                                    <th class="px-4 py-2">{{ __('Player count') }}</th>
                                    <th class="px-4 py-2">{{ __('Goalkeeper count') }}</th>
                                    <th class="px-4 py-2">{{ __('Time') }}</th>
                                    <th class="px-4 py-2">{{ __('Delete row') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rows as $index => $row)
                                    <tr wire:key="row-{{ $index }}" class="border-b border-zinc-200 hover:bg-zinc-50">
                                        <td class="px-4 py-3 text-center text-sm font-medium">{{ $index + 1 }}</td>
                                        <td class="px-4 py-3">
                                            <flux:select
                                                wire:model="rows.{{ $index }}.exerciseId"
                                                searchable
                                                placeholder="{{ __('Search exercise...') }}"
                                            >
                                                @foreach($exercises as $exercise)
                                                    <flux:select.option value="{{ $exercise->id }}">
                                                        {{ $exercise->name }}
                                                    </flux:select.option>
                                                @endforeach
                                            </flux:select>
                                        </td>
                                        <td class="px-4 py-3">
                                            <flux:input wire:model="rows.{{ $index }}.coaches" />
                                        </td>
                                        <td class="px-4 py-3">
                                            <flux:input type="number" wire:model="rows.{{ $index }}.playerCount" />
                                        </td>
                                        <td class="px-4 py-3">
                                            <flux:input type="number" wire:model="rows.{{ $index }}.goalkeeperCount" />
                                        </td>
                                        <td class="px-4 py-3">
                                            <flux:input wire:model="rows.{{ $index }}.time" />
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <flux:button
                                                type="button"
                                                wire:click="removeRow({{ $index }})"
                                                variant="danger"
                                                size="sm"
                                                icon="x-mark"
                                            />
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Card View -->
                    <div class="md:hidden space-y-4">
                        @foreach($rows as $index => $row)
                            <div wire:key="mobile-row-{{ $index }}" class="bg-zinc-50 rounded-lg p-4 space-y-3">
                                <div class="flex items-center justify-between">
                                    <flux:badge>{{ __('#') }}{{ $index + 1 }}</flux:badge>
                                    <flux:button
                                        type="button"
                                        wire:click="removeRow({{ $index }})"
                                        variant="danger"
                                        size="sm"
                                        icon="x-mark"
                                    />
                                </div>

                                <flux:field>
                                    <flux:label>{{ __('Exercise') }}</flux:label>
                                    <flux:select
                                        wire:model="rows.{{ $index }}.exerciseId"
                                        searchable
                                        placeholder="{{ __('Search exercise...') }}"
                                    >
                                        @foreach($exercises as $exercise)
                                            <flux:select.option value="{{ $exercise->id }}">
                                                {{ $exercise->name }}
                                            </flux:select.option>
                                        @endforeach
                                    </flux:select>
                                </flux:field>

                                <flux:field>
                                    <flux:label>{{ __('Coaches') }}</flux:label>
                                    <flux:input wire:model="rows.{{ $index }}.coaches" />
                                </flux:field>

                                <div class="grid grid-cols-2 gap-3">
                                    <flux:field>
                                        <flux:label>{{ __('Player count') }}</flux:label>
                                        <flux:input type="number" wire:model="rows.{{ $index }}.playerCount" />
                                    </flux:field>

                                    <flux:field>
                                        <flux:label>{{ __('Goalkeeper count') }}</flux:label>
                                        <flux:input type="number" wire:model="rows.{{ $index }}.goalkeeperCount" />
                                    </flux:field>
                                </div>

                                <flux:field>
                                    <flux:label>{{ __('Time') }}</flux:label>
                                    <flux:input wire:model="rows.{{ $index }}.time" />
                                </flux:field>
                            </div>
                        @endforeach
                    </div>

                    <div class="flex justify-between mt-4">
                        <flux:button wire:click="addRow" type="button" icon="plus">
                            {{ __('Add row') }}
                        </flux:button>
                        <flux:button type="submit" variant="primary">
                            {{ __('Create Practice') }}
                        </flux:button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

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

                    <div class="overflow-x-auto">
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
                                        <td class="px-4 py-3 relative">
                                            <div class="relative">
                                                <flux:input
                                                    wire:model="rows.{{ $index }}.exercise"
                                                    wire:keyup="updateSearchTerm($event.target.value)"
                                                    wire:click="setActiveRow({{ $index }})"
                                                    placeholder="{{ __('Search exercise...') }}"
                                                />

                                                @if($activeRowIndex === $index && !empty($searchResults))
                                                    <div class="absolute z-10 w-full mt-1 bg-white rounded-md shadow-lg border border-zinc-200">
                                                        <ul class="py-1 overflow-auto text-base leading-6 rounded-md max-h-60 focus:outline-none sm:text-sm sm:leading-5">
                                                            @foreach($searchResults as $result)
                                                                <li wire:click="selectExercise('{{ $result['id'] }}', '{{ $result['name'] }}')"
                                                                    class="px-4 py-2 cursor-pointer hover:bg-zinc-100">
                                                                    {{ $result['name'] }}
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif
                                            </div>
                                            <input type="hidden" wire:model="rows.{{ $index }}.exerciseId">
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

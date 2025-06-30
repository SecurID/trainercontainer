<div>
    <form wire:submit="save">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="grid grid-cols-2 gap-4 mb-4 justify-between">
                    <div>
                        <label for="date" class="text-sm font-bold text-gray-700">{{__('Datum')}}</label>
                        <x-datepicker wire:model="date" name="date"></x-datepicker>
                    </div>
                    <div>
                        <label for="topic" class="text-sm font-bold text-gray-700">{{__('Topic')}}</label>
                        <div>
                            <x-input type="text" id="topic" wire:model="topic" name="topic"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md"
                                   placeholder="{{__('1 on 1')}}" />
                        </div>
                    </div>
                </div>
                <div>
                    <h3 class="py-4 text-center text-xl font-bold text-gray-800">{{__('Schedule')}}</h3>
                    <table class="w-full table-auto">
                        <thead>
                        <tr class="text-center text-white bg-gray-800">
                            <th class="px-4 py-2">{{__('#')}}</th>
                            <th class="px-4 py-2">{{__('Exercise')}}</th>
                            <th class="px-4 py-2">{{__('Coaches')}}</th>
                            <th class="px-4 py-2">{{__('Player count')}}</th>
                            <th class="px-4 py-2">{{__('Goalkeeper count')}}</th>
                            <th class="px-4 py-2">{{__('Time')}}</th>
                            <th class="px-4 py-2">{{__('Delete row')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($rows as $index => $row)
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="px-4 py-3 text-center text-sm font-medium">{{ $index + 1 }}</td>
                                <td class="px-4 py-3 relative">
                                    <div class="relative">
                                        <x-input type="text"
                                               wire:model="rows.{{ $index }}.exercise"
                                               wire:keyup="updateSearchTerm($event.target.value)"
                                               wire:click="setActiveRow({{ $index }})"
                                               class="w-full px-3 py-2 bg-gray-100 rounded cursor-text shadow-sm"
                                               placeholder="{{__('Search exercise...')}}" />

                                        @if($activeRowIndex === $index && !empty($searchResults))
                                            <div class="absolute z-10 w-full mt-1 bg-white rounded-md shadow-lg">
                                                <ul class="py-1 overflow-auto text-base leading-6 rounded-md max-h-60 focus:outline-none sm:text-sm sm:leading-5">
                                                    @foreach($searchResults as $result)
                                                        <li wire:click="selectExercise('{{ $result['id'] }}', '{{ $result['name'] }}')"
                                                            class="px-4 py-2 cursor-pointer hover:bg-gray-100">
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
                                    <x-input type="text"
                                           wire:model="rows.{{ $index }}.coaches"
                                           class="w-full px-3 py-2 bg-gray-100 rounded cursor-text shadow-sm" />
                                </td>
                                <td class="px-4 py-3">
                                    <input type="number"
                                           wire:model="rows.{{ $index }}.playerCount"
                                           class="w-full px-3 py-2 bg-gray-100 rounded cursor-text shadow-sm">
                                </td>
                                <td class="px-4 py-3">
                                    <input type="number"
                                           wire:model="rows.{{ $index }}.goalkeeperCount"
                                           class="w-full px-3 py-2 bg-gray-100 rounded cursor-text shadow-sm">
                                </td>
                                <td class="px-4 py-3">
                                    <x-input type="text"
                                           wire:model="rows.{{ $index }}.time"
                                           class="w-full px-3 py-2 bg-gray-100 rounded cursor-text shadow-sm" />
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <button type="button" wire:click="removeRow({{ $index }})"
                                            class="py-2 px-4 text-white bg-red-600 rounded hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 transition duration-300">
                                        X
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="flex justify-between mt-4">
                        <button wire:click="addRow"
                                type="button"
                                class="py-2 px-4 bg-blue-500 text-white rounded hover:bg-blue-700 transition duration-300">
                            {{ __('Add row') }}
                        </button>
                        <button type="submit"
                                class="py-2 px-4 bg-blue-500 text-white rounded hover:bg-blue-700 transition duration-300">
                            {{ __('Create Practice') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

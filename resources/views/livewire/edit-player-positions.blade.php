<div id="edit-player-positions-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    {{__('Positions of')}} {{ $player->getFullname() }}
                </h3>
                <button type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="edit-player-positions-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5">
                <form class="space-y-4" wire:submit="save">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="main_position" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                {{ __('Main Position') }}
                            </label>
                            <select
                                id="main_position"
                                wire:model="main_position_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                            >
                                <option value="">{{ __('Select main position') }}</option>
                                @foreach($positions as $position)
                                    <option value="{{ $position->id }}">{{ $position->name }} ({{ $position->abbreviation }})</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                            <label for="sub_positions" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                {{ __('Sub Positions') }}
                            </label>
                            <select
                                id="sub_positions"
                                wire:model="sub_position_ids"
                                multiple
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                size="6"
                            >
                                @foreach($positions as $position)
                                    <option value="{{ $position->id }}">{{ $position->name }} ({{ $position->abbreviation }})</option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ __('Hold Ctrl/Cmd to select multiple positions') }}</p>
                        </div>
                    </div>
                    
                    <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" data-modal-hide="edit-player-positions-modal">
                        {{__('Save Positions')}}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

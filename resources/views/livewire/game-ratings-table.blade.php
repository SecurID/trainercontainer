<div>
    <flux:accordion transition>
        <flux:accordion.item :expanded="!$isCollapsed">
            <flux:accordion.heading>
                <flux:heading size="lg">{{ __('Player Ratings') }}</flux:heading>
            </flux:accordion.heading>
            <flux:accordion.content>
                <!-- Player Cards -->
                <div class="space-y-3 pt-4">
                    @foreach($players as $index => $player)
                        <flux:card class="p-4">
                            <!-- Player Header -->
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-4 gap-2">
                                <div class="flex items-center space-x-3">
                                    <flux:badge color="zinc" class="w-8 h-8 flex items-center justify-center rounded-full">
                                        {{ $index + 1 }}
                                    </flux:badge>
                                    <flux:heading size="sm">{{ $player->getFullnameLastFirst() }}</flux:heading>
                                </div>

                                <!-- Not Attended Checkbox -->
                                <flux:checkbox
                                    wire:model.live="attendances.{{ $player->id }}"
                                    label="{{ __('Not attended') }}"
                                />
                            </div>

                            <!-- Rating Section -->
                            <div class="space-y-3">
                                <flux:text size="sm" class="font-medium">{{ __('Rating') }}:</flux:text>
                                <div class="grid grid-cols-5 gap-2 sm:gap-3">
                                    @for($i = 1; $i <= 5; $i++)
                                        <label class="cursor-pointer group">
                                            <input type="radio"
                                                   wire:model.live="ratings.{{ $player->id }}"
                                                   value="{{ $i }}"
                                                   class="sr-only"
                                                   @if(isset($attendances[$player->id]) && $attendances[$player->id] === true) disabled @endif>
                                            <div class="flex items-center justify-center h-12 sm:h-10 lg:h-8 w-full border-2 rounded-lg transition-all duration-200 text-center
                                                {{ (isset($ratings[$player->id]) && $ratings[$player->id] == $i) ? 'border-primary-500 bg-primary-500 text-white shadow-md' : 'border-zinc-300 bg-white text-zinc-900 dark:border-zinc-600 dark:bg-zinc-800 dark:text-zinc-100' }}
                                                {{ (isset($attendances[$player->id]) && $attendances[$player->id] === true) ? 'opacity-40 cursor-not-allowed' : 'hover:border-primary-400 hover:bg-primary-50 dark:hover:bg-primary-900/20 group-hover:scale-105' }}">
                                                <span class="text-lg sm:text-base lg:text-sm font-bold">{{ $i }}</span>
                                            </div>
                                        </label>
                                    @endfor
                                </div>
                            </div>
                        </flux:card>
                    @endforeach
                </div>

                <!-- Save Section -->
                <div class="mt-6 space-y-4">
                    @if($success)
                        <flux:callout variant="success" icon="check-circle">
                            {{ __('Ratings saved successfully!') }}
                        </flux:callout>
                    @endif

                    <flux:button wire:click="saveRatings" variant="primary" class="w-full" icon="check">
                        {{ __('Save Ratings') }}
                    </flux:button>
                </div>
            </flux:accordion.content>
        </flux:accordion.item>
    </flux:accordion>
</div>

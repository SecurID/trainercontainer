
<div class="p-6 bg-bg-primary overflow-hidden sm:rounded-lg">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div>
            <x-label for="topic" value="{{ __('Topic') }}" />
            <x-input
                type="text"
                id="topic"
                wire:model.live.blur="topic"
                name="topic"
                class="mt-1 block w-full"
                placeholder="{{ __('Practice topic') }}"
            />
        </div>

        <div>
            <x-label for="date" value="{{ __('Date') }}" />
            <x-input
                type="date"
                id="date"
                wire:model.live="date"
                name="date"
                class="mt-1 block w-full"
            />
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div>
            <x-label for="playerCount" value="{{ __('Player count') }}" />
            <x-input
                type="number"
                id="playerCount"
                wire:model.live="playerCount"
                name="playerCount"
                class="mt-1 block w-full"
                min="0"
            />
        </div>

        <div>
            <x-label for="goalkeeperCount" value="{{ __('Goalkeeper count') }}" />
            <x-input
                type="number"
                id="goalkeeperCount"
                wire:model.live="goalkeeperCount"
                name="goalkeeperCount"
                class="mt-1 block w-full"
                min="0"
            />
        </div>
    </div>

    @if($successMessage)
        <div class="mb-4">
            <div class="px-4 py-3 bg-success-green text-text-inverse rounded-md text-sm font-medium flex items-center animate-pulse"
                 x-data="{ show: true }"
                 x-show="show"
                 x-init="setTimeout(() => { show = false; $wire.clearSuccessMessage(); }, 2000)">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                {{ $successMessage }}
            </div>
        </div>
    @endif
</div>


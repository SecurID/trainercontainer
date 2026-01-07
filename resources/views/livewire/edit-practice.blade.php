<div class="p-6 bg-white overflow-hidden sm:rounded-lg">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <flux:field>
            <flux:label>{{ __('Topic') }}</flux:label>
            <flux:input
                wire:model.live.blur="topic"
                placeholder="{{ __('Practice topic') }}"
            />
            <flux:error name="topic" />
        </flux:field>

        <flux:field>
            <flux:label>{{ __('Date') }}</flux:label>
            <flux:input
                type="date"
                wire:model.live="date"
            />
            <flux:error name="date" />
        </flux:field>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <flux:field>
            <flux:label>{{ __('Player count') }}</flux:label>
            <flux:input
                type="number"
                wire:model.live.blur="playerCount"
                min="0"
            />
            <flux:error name="playerCount" />
        </flux:field>

        <flux:field>
            <flux:label>{{ __('Goalkeeper count') }}</flux:label>
            <flux:input
                type="number"
                wire:model.live.blur="goalkeeperCount"
                min="0"
            />
            <flux:error name="goalkeeperCount" />
        </flux:field>
    </div>

    <div class="mb-6">
        <flux:field>
            <flux:label>{{ __('Notes') }}</flux:label>
            <div class="mt-1" wire:ignore>
                <trix-editor
                    wire:trix-blur="setNotesContent($event.target.value)"
                    placeholder="{{ __('Practice notes and observations...') }}"
                    class="trix-content"
                    x-data="{
                        init() {
                            this.$el.addEventListener('trix-initialize', () => {
                                this.$el.value = @js($notes ?? '');
                            });
                        }
                    }"
                ></trix-editor>
            </div>
        </flux:field>
    </div>

    @if($successMessage)
        <div class="mb-4">
            <div class="px-4 py-3 bg-green-600 text-white rounded-md text-sm font-medium flex items-center animate-pulse"
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

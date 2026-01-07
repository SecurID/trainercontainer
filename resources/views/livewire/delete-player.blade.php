<div>
    @if ($confirmingDeletion)
        <div class="flex flex-wrap items-center gap-3">
            <flux:text size="sm">{{ __('Delete this player?') }}</flux:text>
            <div class="flex items-center gap-2">
                <flux:button
                    wire:click="deletePlayer"
                    variant="danger"
                    size="sm"
                    icon="trash"
                >
                    {{ __('Yes, delete') }}
                </flux:button>
                <flux:button
                    wire:click="cancelDeletion"
                    size="sm"
                >
                    {{ __('Cancel') }}
                </flux:button>
            </div>
        </div>
    @else
        <flux:button
            wire:click="confirmDeletion"
            variant="danger"
            size="sm"
            icon="trash"
        >
            {{ __('Delete Player') }}
        </flux:button>
    @endif
</div>

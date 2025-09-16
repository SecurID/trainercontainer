<div>
    @if ($confirmingDeletion)
        <div class="flex flex-wrap items-center gap-3">
            <span class="text-sm text-gray-700">{{ __('Delete this player?') }}</span>
            <div class="flex items-center gap-2">
                <button
                    type="button"
                    wire:click="deletePlayer"
                    class="inline-flex items-center gap-2 rounded-md border border-red-300 bg-red-50 px-3 py-1.5 text-sm font-semibold text-red-600 shadow-sm transition hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-red-300 focus:ring-offset-2"
                >
                    <x-heroicon-o-trash class="h-4 w-4" />
                    {{ __('Yes, delete') }}
                </button>
                <button
                    type="button"
                    wire:click="cancelDeletion"
                    class="inline-flex items-center gap-2 rounded-md border border-gray-200 bg-white px-3 py-1.5 text-sm font-medium text-gray-700 shadow-sm transition hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 focus:ring-offset-2"
                >
                    {{ __('Cancel') }}
                </button>
            </div>
        </div>
    @else
        <button
            type="button"
            wire:click="confirmDeletion"
            class="inline-flex items-center gap-2 rounded-md border border-red-300 bg-red-50 px-3 py-1.5 text-sm font-semibold text-red-600 shadow-sm transition hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-red-300 focus:ring-offset-2"
        >
            <x-heroicon-o-trash class="h-4 w-4" />
            {{ __('Delete Player') }}
        </button>
    @endif
</div>

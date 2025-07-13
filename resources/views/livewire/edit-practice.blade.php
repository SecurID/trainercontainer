<div class="mb-6 flex flex-col md:flex-row gap-4 items-center justify-between">
    <div class="flex flex-col md:flex-row gap-4 items-center">
        <label class="font-semibold flex flex-col md:flex-row md:items-center">
            <span class="mb-1 md:mb-0 md:mr-2">Thema:</span>
            <input type="text" wire:model.live.blurMake="topic"
                class="border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 transition-all duration-200" />
        </label>
        <label class="font-semibold flex flex-col md:flex-row md:items-center">
            <span class="mb-1 md:mb-0 md:mr-2">Datum:</span>
            <input type="date" wire:model.live="date"
                class="border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 transition-all duration-200" />
        </label>
    </div>

    <div class="flex items-center space-x-2">
        @if($successMessage)
            <div class="px-3 py-1 bg-green-100 text-green-800 rounded-md text-sm font-medium animate-pulse">
                {{ $successMessage }}
            </div>
        @endif
    </div>
</div>

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('success-message', () => {
            setTimeout(() => {
                @this.set('successMessage', '');
            }, 2000);
        });
    });
</script>

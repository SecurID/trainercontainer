<div class="flex items-center gap-2">
    <input type="number" min="1" max="10" step="1" wire:model.defer="value" class="w-16 border rounded px-2 py-1" placeholder="1-10">
    <button wire:click="save" class="px-2 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">Speichern</button>
    @if($ratingId)
        <span class="text-green-600 ml-2">Gespeichert!</span>
    @endif
    @error('value')
        <span class="text-red-600 ml-2">{{ $message }}</span>
    @enderror
</div>

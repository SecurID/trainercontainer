<form wire:submit="save">
    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('message') }}
        </div>
    @endif

    <div class="w-full mb-4">
        <input
            type="text"
            class="border-border-default focus:border-primary-500 focus:ring-0 rounded-md shadow-sm w-full"
            placeholder="{{ __('Name') }}"
            name="name"
            wire:model="name"
            required
        >
        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <div class="w-full mb-4">
        <textarea
            class="border-border-default focus:border-primary-500 focus:ring-0 rounded-md shadow-sm w-full"
            placeholder="{{ __('Notes') }}"
            name="notes"
            wire:model="notes"
            rows="4"
        ></textarea>
        @error('notes') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <div class="flex justify-end">
        <button type="submit" class="px-4 py-2 bg-primary-500 hover:bg-primary-600 text-text-inverse font-bold rounded">
            {{ __('Create Opponent') }}
        </button>
    </div>
</form>

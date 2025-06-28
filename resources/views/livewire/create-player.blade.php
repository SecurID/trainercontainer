<form wire:submit="save">
    <div class="flex flex-wrap -mx-2">
        <div class="w-full md:w-1/2 px-2 mb-4">
            <input
                type="text"
                class="form-input rounded-md shadow-sm w-full"
                placeholder="{{ __('Pre name') }}"
                name="prename"
                wire:model="prename"
            >
        </div>
        <div class="w-full md:w-1/2 px-2 mb-4">
            <input
                type="text"
                class="form-input rounded-md shadow-sm w-full"
                placeholder="{{ __('Last name') }}"
                name="lastname"
                wire:model="lastname"
            >
        </div>
    </div>
    <div class="flex justify-end">
        <button type="submit"  class="px-4 py-2 bg-green-500 hover:bg-green-700 text-white font-bold rounded">
            {{ __('Create Player') }}
        </button>
    </div>
</form>



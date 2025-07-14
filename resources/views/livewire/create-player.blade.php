<form wire:submit="save">
    <div class="flex flex-wrap -mx-2">
        <div class="w-full md:w-1/2 px-2 mb-4">
            <input
                type="text"
                class="border-border-default focus:border-primary-500 focus:ring-0 rounded-md shadow-sm w-full"
                placeholder="{{ __('Pre name') }}"
                name="prename"
                wire:model="prename"
            >
        </div>
        <div class="w-full md:w-1/2 px-2 mb-4">
            <input
                type="text"
                class="border-border-default focus:border-primary-500 focus:ring-0 rounded-md shadow-sm w-full"
                placeholder="{{ __('Last name') }}"
                name="lastname"
                wire:model="lastname"
            >
        </div>
    </div>
    
    <div class="flex flex-wrap -mx-2">
        <div class="w-full md:w-1/2 px-2 mb-4">
            <label for="main_position" class="block text-sm font-medium text-text-primary mb-2">
                {{ __('Main Position') }}
            </label>
            <select
                id="main_position"
                wire:model="main_position_id"
                class="border-border-default focus:border-primary-500 focus:ring-0 rounded-md shadow-sm w-full text-text-secondary"
            >
                <option value="">{{ __('Select main position') }}</option>
                @foreach($positions as $position)
                    <option value="{{ $position->id }}">{{ $position->name }} ({{ $position->abbreviation }})</option>
                @endforeach
            </select>
        </div>
        
        <div class="w-full md:w-1/2 px-2 mb-4">
            <label for="sub_positions" class="block text-sm font-medium text-text-primary mb-2">
                {{ __('Sub Positions') }}
            </label>
            <select
                id="sub_positions"
                wire:model="sub_position_ids"
                multiple
                class="border-border-default focus:border-primary-500 focus:ring-0 rounded-md shadow-sm w-full text-text-secondary"
            >
                @foreach($positions as $position)
                    <option value="{{ $position->id }}">{{ $position->name }} ({{ $position->abbreviation }})</option>
                @endforeach
            </select>
            <p class="text-xs text-text-tertiary mt-1">{{ __('Hold Ctrl/Cmd to select multiple positions') }}</p>
        </div>
    </div>
    
    <div class="flex justify-end">
        <button type="submit"  class="px-4 py-2 bg-primary-500 hover:bg-primary-600 text-text-inverse font-bold rounded">
            {{ __('Create Player') }}
        </button>
    </div>
</form>



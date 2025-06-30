<div>
    <form wire:submit.prevent="save" enctype="multipart/form-data">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <x-input type="text" class="w-full" placeholder="{{ __('Name') }}" wire:model.defer="name" />
            <x-input type="text" class="w-full" placeholder="{{ __('Focus') }}" wire:model.defer="focus" />
        </div>
        <!-- Multiple categories selection -->
        <div class="grid grid-cols-1 mb-4 w-full">
            <x-multiselect
                wire:model="categories"
                :options="$categoriesList->map(fn($c) => ['id' => $c->id, 'name' => __($c->name)])->values()"
                :placeholder="__('Choose Categories')"
            />
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-4 mb-4">
            <x-input type="text" class="lg:col-span-3 w-full" placeholder="{{ __('Material') }}" wire:model.defer="material" />
            <div class="flex lg:col-span-1">
                <x-input type="text" class="w-full" placeholder="{{ __('Duration') }}" wire:model.defer="duration" />
                <p class="my-auto mx-1 items-center text-gray-500">{{__('minutes')}}</p>
            </div>
            <div class="flex lg:col-span-1">
                <x-input type="text" class="w-full" placeholder="{{ __('Intensity') }}" wire:model.defer="intensity" />
                <p class="my-auto mx-1 items-center">%</p>
            </div>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-4 mb-4">
            <x-input type="number" class=""
                   placeholder="{{ __('Player count') }}" wire:model.defer="playerCount" />
            <x-input type="number" class=""
                   placeholder="{{ __('Goalkeeper count') }}" wire:model.defer="goalkeeperCount" />
            <x-select wire:model.defer="level">
                <option>{{ __('Choose Level') }}</option>
                <option value="1">{{ __('Beginner') }}</option>
                <option value="2">{{ __('Intermediate') }}</option>
                <option value="3">{{ __('Advanced') }}</option>
                <option value="4">{{ __('Expert') }}</option>
            </x-select>
            <x-input type="number" class=""
                   placeholder="{{ __('From Age') }}" wire:model.defer="age" />
        </div>
        <x-textarea placeholder="{{ __('Procedure') }}" wire:model.defer="procedure" />
        <x-textarea placeholder="{{ __('Coaching') }}" wire:model.defer="coaching" />
        <div class="md:flex block items-center mb-4">
            <label for="image" class="block text-md font-bold text-gray-500 mr-4 mb-2">
                {{ __('Drawing') }}
            </label>
            <input type="file"
                   class="form-input rounded-md shadow-sm border-[1px] border-gray-500 w-full text-gray-500"
                   wire:model="image">
        </div>
        <div class="flex justify-end">
            <button type="submit"
                    class="px-4 py-2 bg-green-500 hover:bg-green-700 text-white font-bold rounded">
                {{ __('Create Exercise') }}
            </button>
        </div>
    </form>
</div>

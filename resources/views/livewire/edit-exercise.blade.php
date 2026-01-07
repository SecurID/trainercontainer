<div>
    <form wire:submit.prevent="update" enctype="multipart/form-data">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <flux:field>
                <flux:label>{{ __('Name') }}</flux:label>
                <flux:input wire:model.defer="name" placeholder="{{ __('Name') }}" />
                <flux:error name="name" />
            </flux:field>

            <flux:field>
                <flux:label>{{ __('Focus') }}</flux:label>
                <flux:input wire:model.defer="focus" placeholder="{{ __('Focus') }}" />
                <flux:error name="focus" />
            </flux:field>
        </div>

        <div class="grid grid-cols-1 mb-4 w-full">
            <x-multiselect
                wire:model="categories"
                :options="$categoriesList->map(fn($c) => ['id' => $c->id, 'name' => __($c->name)])->values()"
                :placeholder="__('Choose Categories')"
            />
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-4 mb-4">
            <flux:field class="lg:col-span-3">
                <flux:label>{{ __('Material') }}</flux:label>
                <flux:input wire:model.defer="material" placeholder="{{ __('Material') }}" />
                <flux:error name="material" />
            </flux:field>

            <div class="flex items-end gap-1 lg:col-span-1">
                <flux:field class="flex-1">
                    <flux:label>{{ __('Duration') }}</flux:label>
                    <flux:input wire:model.defer="duration" placeholder="{{ __('Duration') }}" />
                    <flux:error name="duration" />
                </flux:field>
                <span class="text-zinc-500 pb-2">{{ __('minutes') }}</span>
            </div>

            <div class="flex items-end gap-1 lg:col-span-1">
                <flux:field class="flex-1">
                    <flux:label>{{ __('Intensity') }}</flux:label>
                    <flux:input wire:model.defer="intensity" placeholder="{{ __('Intensity') }}" />
                    <flux:error name="intensity" />
                </flux:field>
                <span class="text-zinc-500 pb-2">%</span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-4 mb-4">
            <flux:field>
                <flux:label>{{ __('Player count') }}</flux:label>
                <flux:input type="number" wire:model.defer="playerCount" placeholder="{{ __('Player count') }}" />
                <flux:error name="playerCount" />
            </flux:field>

            <flux:field>
                <flux:label>{{ __('Goalkeeper count') }}</flux:label>
                <flux:input type="number" wire:model.defer="goalkeeperCount" placeholder="{{ __('Goalkeeper count') }}" />
                <flux:error name="goalkeeperCount" />
            </flux:field>

            <flux:field>
                <flux:label>{{ __('Level') }}</flux:label>
                <flux:select wire:model.defer="level" placeholder="{{ __('Choose Level') }}">
                    <flux:select.option value="1">{{ __('Beginner') }}</flux:select.option>
                    <flux:select.option value="2">{{ __('Intermediate') }}</flux:select.option>
                    <flux:select.option value="3">{{ __('Advanced') }}</flux:select.option>
                    <flux:select.option value="4">{{ __('Expert') }}</flux:select.option>
                </flux:select>
                <flux:error name="level" />
            </flux:field>

            <flux:field>
                <flux:label>{{ __('From Age') }}</flux:label>
                <flux:input type="number" wire:model.defer="age" placeholder="{{ __('From Age') }}" />
                <flux:error name="age" />
            </flux:field>
        </div>

        <div class="space-y-4 mb-4">
            <flux:field>
                <flux:label>{{ __('Procedure') }}</flux:label>
                <flux:textarea wire:model.defer="procedure" placeholder="{{ __('Procedure') }}" rows="3" />
                <flux:error name="procedure" />
            </flux:field>

            <flux:field>
                <flux:label>{{ __('Coaching') }}</flux:label>
                <flux:textarea wire:model.defer="coaching" placeholder="{{ __('Coaching') }}" rows="3" />
                <flux:error name="coaching" />
            </flux:field>
        </div>

        <div class="md:flex block items-center mb-4 gap-4">
            @if($exercise->image)
                <div class="mb-2 md:mb-0">
                    <img src="{{ asset('storage/' . $exercise->image) }}" alt="Current image" class="h-20 w-20 object-cover rounded">
                    <flux:text size="sm">{{ __('Current image') }}</flux:text>
                </div>
            @endif
            <flux:field class="flex-1">
                <flux:label>{{ __('Drawing') }}</flux:label>
                <input type="file"
                       class="block w-full text-sm text-zinc-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-zinc-100 file:text-zinc-700 hover:file:bg-zinc-200"
                       wire:model="image">
                <flux:error name="image" />
            </flux:field>
        </div>

        <div class="flex justify-between">
            <flux:button
                type="button"
                wire:click="delete"
                wire:confirm="{{ __('Are you sure you want to delete this exercise?') }}"
                variant="danger">
                {{ __('Delete Exercise') }}
            </flux:button>
            <flux:button type="submit" variant="primary">
                {{ __('Update Exercise') }}
            </flux:button>
        </div>
    </form>
</div>

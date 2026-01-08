<div>
    <form wire:submit.prevent="create">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <flux:field>
                        <flux:label>{{ __('messages.start_date') }}</flux:label>
                        <flux:date-picker wire:model="start_date" />
                        <flux:error name="start_date" />
                    </flux:field>

                    <flux:field>
                        <flux:label>{{ __('messages.end_date') }}</flux:label>
                        <flux:date-picker wire:model="end_date" />
                        <flux:error name="end_date" />
                    </flux:field>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <flux:field>
                        <flux:label>{{ __('messages.weekdays') }}</flux:label>
                        <div class="flex flex-wrap gap-4 mt-2">
                            <flux:checkbox wire:model="weekdays" value="1" :label="__('messages.monday')" />
                            <flux:checkbox wire:model="weekdays" value="2" :label="__('messages.tuesday')" />
                            <flux:checkbox wire:model="weekdays" value="3" :label="__('messages.wednesday')" />
                            <flux:checkbox wire:model="weekdays" value="4" :label="__('messages.thursday')" />
                            <flux:checkbox wire:model="weekdays" value="5" :label="__('messages.friday')" />
                            <flux:checkbox wire:model="weekdays" value="6" :label="__('messages.saturday')" />
                            <flux:checkbox wire:model="weekdays" value="7" :label="__('messages.sunday')" />
                        </div>
                        <flux:error name="weekdays" />
                    </flux:field>

                    <flux:field>
                        <flux:label>{{ __('messages.time') }}</flux:label>
                        <flux:time-picker wire:model="time" />
                        <flux:error name="time" />
                    </flux:field>
                </div>

                <div class="flex justify-end mt-4">
                    <flux:button type="submit" variant="primary">
                        {{ __('actions.create') }}
                    </flux:button>
                </div>

                @if($success)
                    <div class="mt-4 text-green-600 font-semibold">{{ __('messages.practices_created') }}</div>
                @endif
            </div>
        </div>
    </form>
</div>

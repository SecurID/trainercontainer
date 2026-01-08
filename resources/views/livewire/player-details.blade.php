<div>
    <!-- Positions Section -->
    <div class="flex items-center justify-between mb-4">
        <flux:heading>{{ __('Positions') }}</flux:heading>
        <flux:modal.trigger name="edit-player-positions">
            <flux:button variant="subtle" size="sm" icon="clipboard-document-list">
                {{ __('Edit Positions') }}
            </flux:button>
        </flux:modal.trigger>
    </div>
    <div class="mb-4">
        <flux:text size="sm" class="text-zinc-600">{{ __('Main Position') }}:</flux:text>
        <flux:text class="font-semibold">
            @if($player->mainPosition)
                {{ $player->mainPosition->name }} ({{ $player->mainPosition->abbreviation }})
            @else
                <span class="text-zinc-400">{{ __('Not set') }}</span>
            @endif
        </flux:text>
    </div>
    <div class="mb-4">
        <flux:text size="sm" class="text-zinc-600">{{ __('Sub Positions') }}:</flux:text>
        @if($player->subPositions->count() > 0)
            <div class="flex flex-wrap gap-2 mt-1">
                @foreach($player->subPositions as $position)
                    <flux:badge color="blue" size="sm">
                        {{ $position->abbreviation }}
                    </flux:badge>
                @endforeach
            </div>
        @else
            <flux:text class="text-zinc-400">{{ __('None set') }}</flux:text>
        @endif
    </div>

    <!-- Notes Section -->
    <div class="flex items-center justify-between">
        <flux:heading>{{ __('Notes') }}</flux:heading>
        <flux:modal.trigger name="edit-player-notes">
            <flux:button variant="subtle" size="sm" icon="document-text">
                {{ __('Edit Notes') }}
            </flux:button>
        </flux:modal.trigger>
    </div>
    <flux:text class="mt-2">{{ $player->notes }}</flux:text>

    <!-- Edit Name Modal -->
    <flux:modal name="edit-player-name" class="md:w-96">
        <div class="space-y-6">
            <flux:heading size="lg">{{ __('Edit Player Name') }}</flux:heading>

            <form wire:submit="saveName" class="space-y-4">
                <flux:field>
                    <flux:label>{{ __('First Name') }}</flux:label>
                    <flux:input wire:model="prename" />
                    <flux:error name="prename" />
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('Last Name') }}</flux:label>
                    <flux:input wire:model="lastname" />
                    <flux:error name="lastname" />
                </flux:field>

                <div class="flex gap-2 justify-end">
                    <flux:button type="button" x-on:click="$flux.modal('edit-player-name').close()">
                        {{ __('Cancel') }}
                    </flux:button>
                    <flux:button type="submit" variant="primary">
                        {{ __('Save') }}
                    </flux:button>
                </div>
            </form>
        </div>
    </flux:modal>

    <!-- Edit Positions Modal -->
    <flux:modal name="edit-player-positions" class="md:w-xl">
        <div class="space-y-6">
            <flux:heading size="lg">{{ __('Positions of') }} {{ $player->getFullname() }}</flux:heading>

            <form wire:submit="savePositions" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <flux:field>
                        <flux:label>{{ __('Main Position') }}</flux:label>
                        <flux:select wire:model="main_position_id" placeholder="{{ __('Select main position') }}">
                            @foreach($positions as $position)
                                <flux:select.option value="{{ $position->id }}">{{ $position->name }} ({{ $position->abbreviation }})</flux:select.option>
                            @endforeach
                        </flux:select>
                        <flux:error name="main_position_id" />
                    </flux:field>

                    <flux:field>
                        <flux:label>{{ __('Sub Positions') }}</flux:label>
                        <flux:pillbox wire:model="sub_position_ids" multiple searchable placeholder="{{ __('Select sub positions...') }}">
                            @foreach($positions as $position)
                                <flux:pillbox.option value="{{ $position->id }}">{{ $position->name }} ({{ $position->abbreviation }})</flux:pillbox.option>
                            @endforeach
                        </flux:pillbox>
                        <flux:error name="sub_position_ids" />
                    </flux:field>
                </div>

                <div class="flex gap-2 justify-end">
                    <flux:button type="button" x-on:click="$flux.modal('edit-player-positions').close()">
                        {{ __('Cancel') }}
                    </flux:button>
                    <flux:button type="submit" variant="primary">
                        {{ __('Save Positions') }}
                    </flux:button>
                </div>
            </form>
        </div>
    </flux:modal>

    <!-- Edit Notes Modal -->
    <flux:modal name="edit-player-notes" class="md:w-xl">
        <div class="space-y-6">
            <flux:heading size="lg">{{ __('Notes of') }} {{ $player->getFullname() }}</flux:heading>

            <form wire:submit="saveNotes" class="space-y-4">
                <flux:editor wire:model="notes" label="{{ __('Notes') }}" />

                <div class="flex gap-2 justify-end">
                    <flux:button type="button" x-on:click="$flux.modal('edit-player-notes').close()">
                        {{ __('Cancel') }}
                    </flux:button>
                    <flux:button type="submit" variant="primary">
                        {{ __('Save') }}
                    </flux:button>
                </div>
            </form>
        </div>
    </flux:modal>
</div>

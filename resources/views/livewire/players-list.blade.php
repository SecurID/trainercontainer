<div>
    <div class="mb-4">
        <flux:input
            wire:model.live="search"
            placeholder="{{ __('Search players...') }}"
            icon="magnifying-glass"
        />
    </div>

    @if(count($players) === 0)
        @if(empty($search))
            <flux:text class="text-zinc-500">{{ __('No players found.') }} {{ __('Create one by clicking on "Create Player".') }}</flux:text>
        @else
            <flux:text class="text-zinc-500">{{ __('No players found matching your search.') }}</flux:text>
        @endif
    @else
        <flux:table>
            <flux:table.columns>
                <flux:table.column>{{ __('Name') }}</flux:table.column>
                <flux:table.column>{{ __('Position') }}</flux:table.column>
                <flux:table.column></flux:table.column>
            </flux:table.columns>
            <flux:table.rows>
                @foreach($players as $player)
                    <flux:table.row :key="$player->id">
                        <flux:table.cell>
                            <flux:link href="{{ route('players.show', $player->id) }}">
                                {{ $player->lastname }}, {{ $player->prename }}
                            </flux:link>
                        </flux:table.cell>
                        <flux:table.cell>
                            @if($player->mainPosition)
                                <flux:badge color="zinc" size="sm">{{ $player->mainPosition->abbreviation }}</flux:badge>
                            @else
                                <flux:text class="text-zinc-400">-</flux:text>
                            @endif
                        </flux:table.cell>
                        <flux:table.cell>
                            <div class="flex justify-end">
                                <flux:button href="{{ route('players.show', $player->id) }}" variant="ghost" size="sm" icon="eye" />
                            </div>
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    @endif
</div>

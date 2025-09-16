<div>
    <div class="mb-4">
        <input 
            type="text" 
            wire:model.live="search" 
            placeholder="{{ __('Search players...') }}" 
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
        />
    </div>

    <div>
        @if(count($players) === 0)
            @if(empty($search))
                <p class="p-2">{{ __('No players found.') }} {{ __('Create one by clicking on "Create Player".') }}</p>
            @else
                <p class="p-2">{{ __('No players found matching your search.') }}</p>
            @endif
        @endif
        @foreach($players as $player)
            <a href="{{ route('players.show', $player->id) }}" class="block px-4 py-2 mt-2 bg-gray-100 rounded hover:bg-gray-200">
                {{ $player->lastname }}, {{ $player->prename }}
            </a>
        @endforeach
    </div>
</div>

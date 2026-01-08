<div>
    <!-- Category Filter -->
    <div class="flex flex-wrap gap-2 mb-6">
        <flux:button
            wire:click="filterByCategory('all')"
            :variant="$selectedCategoryId == 'all' ? 'primary' : 'filled'"
            size="sm"
        >
            {{ __('All') }}
        </flux:button>
        @foreach($categories as $category)
            <flux:button
                wire:click="filterByCategory('{{ $category->id }}')"
                :variant="$selectedCategoryId == $category->id ? 'primary' : 'filled'"
                size="sm"
            >
                {{ __($category->name) }}
            </flux:button>
        @endforeach
    </div>

    <!-- Exercises Grid -->
    @if(count($exercises) === 0)
        <flux:text class="text-zinc-500">{{ __('No exercises found.') }} {{ __('Create one by clicking on "Create Exercise".') }}</flux:text>
    @else
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach ($exercises as $exercise)
                <a href="{{ route('exercises.show', ['exercise' => $exercise]) }}" class="block group" wire:key="exercise-{{ $exercise->id }}">
                    <flux:card class="h-full overflow-hidden transition-shadow group-hover:shadow-lg">
                        @if($exercise->image)
                            <img class="w-full h-40 object-cover -mt-6 -mx-6 mb-4" style="width: calc(100% + 3rem);" src="{{ asset('storage/' . $exercise->image) }}" alt="{{ $exercise->name }}">
                        @endif
                        <flux:heading size="sm" class="mb-2">{{ $exercise->name }}</flux:heading>
                        <div class="flex flex-wrap gap-2">
                            <flux:badge color="zinc" size="sm" icon="clock">
                                {{ $exercise->duration }} {{ __('min') }}
                            </flux:badge>
                            <flux:badge color="zinc" size="sm" icon="bolt">
                                {{ $exercise->intensity }}%
                            </flux:badge>
                        </div>
                    </flux:card>
                </a>
            @endforeach
        </div>
    @endif
</div>

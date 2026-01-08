<x-app-layout>
    <x-slot name="header">
        <div class="lg:flex sm:space-y-2 justify-between items-center block">
            <div class="flex items-center gap-3">
                <x-back-button></x-back-button>
                <flux:heading size="xl">{{ $exercise->name }}</flux:heading>
            </div>
            <div class="flex gap-2">
                @if($exercise->user_id === auth()->id())
                    <flux:button href="{{ route('exercises.edit', ['exercise' => $exercise]) }}" variant="primary" icon="pencil">
                        {{ __('Edit Exercise') }}
                    </flux:button>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <flux:card>
                <x-exercise-single :exercise="$exercise"></x-exercise-single>
            </flux:card>
        </div>
    </div>
</x-app-layout>

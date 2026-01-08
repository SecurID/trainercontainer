<div>
    <!-- Header with Focus -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-6">
        <flux:heading size="lg">{{ $exercise->name }}</flux:heading>
        @if($exercise->focus)
            <flux:badge color="blue" size="sm">{{ __('Focus') }}: {{ $exercise->focus }}</flux:badge>
        @endif
    </div>

    <!-- Image -->
    @if($exercise->image)
        <div class="flex justify-center mb-6">
            <img class="max-w-full md:max-w-2xl rounded-lg shadow-md" src="{{ asset('storage/' . $exercise->image) }}" alt="{{ $exercise->name }}">
        </div>
    @endif

    <!-- Stats -->
    <div class="flex flex-wrap gap-3 mb-6">
        <flux:badge color="zinc" icon="clock">
            {{ __('Duration') }}: {{ $exercise->duration }} {{ __('minutes') }}
        </flux:badge>
        <flux:badge color="zinc" icon="bolt">
            {{ __('Intensity') }}: {{ $exercise->intensity }}%
        </flux:badge>
        @if($exercise->material)
            <flux:badge color="zinc" icon="cube">
                {{ __('Material') }}: {{ $exercise->material }}
            </flux:badge>
        @endif
    </div>

    <flux:separator class="my-6" />

    <!-- Content Grid -->
    <div class="grid md:grid-cols-2 gap-6">
        @if($exercise->procedure)
            <div>
                <flux:heading size="sm" class="mb-2">{{ __('Procedure') }}</flux:heading>
                <flux:text class="prose dark:prose-invert max-w-none">{!! $exercise->procedure !!}</flux:text>
            </div>
        @endif

        @if($exercise->coaching)
            <div>
                <flux:heading size="sm" class="mb-2">{{ __('Coaching') }}</flux:heading>
                <flux:text class="prose dark:prose-invert max-w-none">{!! $exercise->coaching !!}</flux:text>
            </div>
        @endif
    </div>
</div>

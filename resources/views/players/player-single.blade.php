<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div class="flex items-center gap-3">
                <x-back-button></x-back-button>
                <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:gap-3">
                    <flux:heading size="xl">
                        {{ $player->prename }} {{ $player->lastname }}
                    </flux:heading>
                    <flux:modal.trigger name="edit-player-name">
                        <flux:button variant="subtle" size="sm" icon="pencil">
                            {{ __('Edit Name') }}
                        </flux:button>
                    </flux:modal.trigger>
                </div>
            </div>
            <livewire:delete-player :player="$player" />
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex flex-wrap">
                    <div class="w-full md:w-1/2 lg:w-1/3 p-4">
                        <div class="flex items-center justify-between mb-4">
                            <flux:heading>{{ __('Positions') }}</flux:heading>
                            <flux:modal.trigger name="edit-player-positions">
                                <flux:button variant="subtle" size="sm" icon="clipboard-document-list">
                                    {{ __('Edit Positions') }}
                                </flux:button>
                            </flux:modal.trigger>
                        </div>
                        <livewire:edit-player-positions :player="$player" />
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

                        <div class="flex items-center justify-between">
                            <flux:heading>{{ __('Notes') }}</flux:heading>
                            <flux:modal.trigger name="edit-player-notes">
                                <flux:button variant="subtle" size="sm" icon="document-text">
                                    {{ __('Edit Notes') }}
                                </flux:button>
                            </flux:modal.trigger>
                        </div>
                        <livewire:edit-player-notes :player="$player" />
                        <flux:text class="mt-2">{{ $player->notes }}</flux:text>
                    </div>
                    <div class="w-full md:w-1/2 lg:w-2/3 p-4">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
        <script>
            var ctx = document.getElementById('myChart').getContext('2d');
            var chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($labels),
                    datasets: [{
                        label: 'Rating',
                        data: @json($ratings_array),
                        lineTension: 0,
                        fill: false,
                        borderColor: 'orange',
                        backgroundColor: 'transparent',
                        borderDash: [5, 5],
                        pointBorderColor: 'orange',
                        pointBackgroundColor: 'rgba(255,150,0,0.5)',
                        pointRadius: 5,
                        pointHoverRadius: 10,
                        pointHitRadius: 30,
                        pointBorderWidth: 2,
                        pointStyle: 'rectRounded'
                    }]
                },
                options: {
                    scales: {
                        xAxes: [{
                            ticks: {
                                display: false,
                                autoSkip: false,
                                maxRotation: 90,
                                minRotation: 90,
                            }
                        }],
                        yAxes: [{
                            ticks: {
                                stepSize: 1,
                                min: 0,
                                max: 5,
                                callback: function(label, index, labels) {
                                    switch (label) {
                                        case 0:
                                            return 'NA';
                                        case 1:
                                            return 'very bad (--)';
                                        case 2:
                                            return 'bad (-)';
                                        case 3:
                                            return 'normal (o)';
                                        case 4:
                                            return 'good (+)';
                                        case 5:
                                            return 'very good (++)';
                                    }
                                }
                            }
                        }]
                    }
                }
            });
        </script>
    @endpush
    <livewire:edit-player-name :player="$player" />
</x-app-layout>

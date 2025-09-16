<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div class="flex items-center gap-3">
                <x-back-button></x-back-button>
                <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:gap-3">
                    <h2 class="text-xl font-semibold text-gray-800 leading-tight">
                        {{ $player->prename }} {{ $player->lastname }}
                    </h2>
                    <button
                        type="button"
                        data-modal-target="edit-player-name-modal"
                        data-modal-toggle="edit-player-name-modal"
                        class="inline-flex items-center gap-2 rounded-md border border-primary-200 bg-white px-3 py-1.5 text-sm font-medium text-primary-700 shadow-sm transition hover:bg-primary-50 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:ring-offset-2"
                    >
                        <x-heroicon-o-pencil class="h-4 w-4" />
                        {{ __('Edit Name') }}
                    </button>
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
                            <div class="font-bold">{{__('Positions')}}</div>
                            <button
                                type="button"
                                data-modal-target="edit-player-positions-modal"
                                data-modal-toggle="edit-player-positions-modal"
                                class="inline-flex items-center gap-2 rounded-md border border-primary-200 bg-white px-3 py-1.5 text-sm font-medium text-primary-700 shadow-sm transition hover:bg-primary-50 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:ring-offset-2"
                            >
                                <x-heroicon-o-clipboard-document-list class="h-4 w-4" />
                                {{__('Edit Positions')}}
                            </button>
                        </div>
                        <livewire:edit-player-positions :player="$player"></livewire:edit-player-positions>
                        <div class="mb-4">
                            <p class="text-sm text-gray-600">{{__('Main Position')}}:</p>
                            <p class="font-semibold">
                                @if($player->mainPosition)
                                    {{ $player->mainPosition->name }} ({{ $player->mainPosition->abbreviation }})
                                @else
                                    <span class="text-gray-400">{{__('Not set')}}</span>
                                @endif
                            </p>
                        </div>
                        <div class="mb-4">
                            <p class="text-sm text-gray-600">{{__('Sub Positions')}}:</p>
                            @if($player->subPositions->count() > 0)
                                <div class="flex flex-wrap gap-2 mt-1">
                                    @foreach($player->subPositions as $position)
                                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">
                                            {{ $position->abbreviation }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-400">{{__('None set')}}</p>
                            @endif
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="font-bold">{{__('Notes')}}</div>
                            <button
                                type="button"
                                data-modal-target="edit-player-modal"
                                data-modal-toggle="edit-player-modal"
                                class="inline-flex items-center gap-2 rounded-md border border-primary-200 bg-white px-3 py-1.5 text-sm font-medium text-primary-700 shadow-sm transition hover:bg-primary-50 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:ring-offset-2"
                            >
                                <x-heroicon-o-document-text class="h-4 w-4" />
                                {{__('Edit Notes')}}
                            </button>
                        </div>
                        <livewire:edit-player-notes :player="$player"></livewire:edit-player-notes>
                        <p class="mt-2">{{ $player->notes }}</p>
                    </div>
                    <div class="w-full md:w-1/2 lg:w-2/3 p-4">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('jsscripts')
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

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <div>
                <a href="{{ route('players.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                    </svg>
                    Zurück
                </a>
            </div>
            <h2 class="flex-grow text-xl font-semibold text-gray-800 leading-tight">
                {{ $player->prename }} {{ $player->lastname }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex flex-wrap">
                    <div class="w-full md:w-1/2 lg:w-1/3 p-4">
                        <div class="font-bold">Notes:</div>
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
</x-app-layout>

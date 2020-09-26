<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col-md-1">
                <a href="{{ route('players.index') }}"><button>Zurück</button></a>
            </div>
            <div class="col">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ $player->prename }} {{$player->name}}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <b>Notes:</b> <p class="card-text">{!! $player->notes!!}</p>
                            </div>
                            <div class="col-md-8">
                                <canvas id="myChart" style="width: 50%;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('jsscripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" integrity="sha512-s+xg36jbIujB2S2VKfpGmlC3T5V2TF3lY48DX7u2r9XzGzgPsa6wTpOQA7J9iffvdeBN0q9tKzRxVxw1JviZPg==" crossorigin="anonymous"></script>
        <script>
            var ctx = document.getElementById('myChart').getContext('2d');
            var chart = new Chart(ctx, {
                // The type of chart we want to create
                type: 'line',

                // The data for our dataset
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

                // Configuration options go here
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

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Practice Schedule and Exercises</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @page {
            margin: 10mm
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>

<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
        <div class="mb-4 text-xl font-bold text-gray-800 text-center">{{ __('Schedule') }} {{__('Practice')}} - {{ \Carbon\Carbon::parse($practice->date)->format('d.m.Y') }} - {{ $practice->topic }}</div>
        <table class="w-full table-auto">
            <thead>
            <tr class="text-center text-white bg-green-800">
                <th class="px-4 py-2">#</th>
                <th class="px-4 py-2">{{ __('Exercise') }}</th>
                <th class="px-4 py-2">{{__('Coaches')}}</th>
                <th class="px-4 py-2">{{__('Player count')}}</th>
                <th class="px-4 py-2">{{__('Goalkeeper count')}}</th>
                <th class="px-4 py-2">{{__('Time')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($schedules as $schedule)
                <tr class="text-center">
                    <td class="px-4 py-2">{{ $loop->index + 1 }}</td>
                    <td class="px-4 py-2">{{ \App\Models\Exercise::find($schedule->exercise_id)->name }}</td>
                    <td class="px-4 py-2">{{ $schedule->coaches }}</td>
                    <td class="px-4 py-2">{{ $schedule->playerCount }}</td>
                    <td class="px-4 py-2">{{ $schedule->goalkeeperCount }}</td>
                    <td class="px-4 py-2">{{ $schedule->time }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="shrink-0 flex items-center justify-end mt-10">
        <p class="mr-10">{{__('Powered by')}}</p>
        <a href="https://trainercontainer.de">
            <img src="https://trainercontainer.s3.eu-central-1.amazonaws.com/logo_trainercontainer.png" class="block h-12 w-auto my-5"/>
        </a>
    </div>
</div>

@foreach($schedules as $schedule)
    @php($exercise = \App\Models\Exercise::find($schedule->exercise_id))
    <div class="page-break"></div>
    <div class="mx-auto px-6">
        <div class="bg-white overflow-hidden">
            <div class="flex justify-between">
                <h5 class="text-2xl"><span class="font-bold">{{$exercise->name}}</span></h5>
                <p class="text-lg">{{__('Focus')}}: {{$exercise->focus}}</p>
            </div>
            @if($exercise->image)
                <div class="flex justify-center py-4">
                    <img class="w-1/2" src="{{$exercise->image}}" alt="{{$exercise->name}}">
                </div>
            @endif
            <div class="mt-4">
                <hr class="my-2">
                <div class="grid grid-cols-5 gap-2">
                    <div class="col-span-2"><b>{{ __('Procedure') }}:</b>
                        <pre class="font-sans text-wrap">{!! $exercise->procedure !!}</pre>
                    </div>
                    <div class="col-span-2"><b>{{ __('Coaching') }}:</b>
                        <pre class="font-sans text-wrap">{!! $exercise->coaching !!}</pre>
                    </div>
                    <div class="col-span-1">
                        <p><b>{{ __('Duration') }}:</b> {{$exercise->duration}}<br>
                            <b>{{ __('Intensity') }}:</b> {{$exercise->intensity}}%<br>
                            <b>{{__('Material')}}:</b> {{$exercise->material}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
</body>
</html>

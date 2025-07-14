@php use App\Models\Exercise; @endphp
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
        <div class="mb-4 text-xl font-bold text-gray-800 text-center">{{ __('Schedule') }} {{__('Practice')}}
            - {{ \Carbon\Carbon::parse($practice->date)->format('d.m.Y') }} - {{ $practice->topic }}</div>
        <table class="w-full table-auto">
            <thead>
            <tr class="text-center text-white bg-teal-600">
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
                    <td class="px-4 py-2">{{ Exercise::find($schedule->exercise_id)->name }}</td>
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
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-teal-600 rounded-full flex items-center justify-center">
                        <span class="text-white text-xl font-bold">t</span>
                    </div>
                </div>
                <span class="ml-3 text-xl font-bold text-gray-900">trainercontainer</span>
            </div>
        </a>
    </div>
</div>

@foreach($schedules as $schedule)
    @php($exercise = Exercise::find($schedule->exercise_id))
    <div class="page-break"></div>
    <x-exercise-single :exercise="$exercise"></x-exercise-single>
@endforeach
</body>
</html>

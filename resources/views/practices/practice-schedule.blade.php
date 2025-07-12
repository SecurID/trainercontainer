@php use App\Models\Exercise; @endphp
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <x-back-button></x-back-button>
            <h2 class="ml-2 text-xl font-semibold text-gray-800 leading-tight">
                {{__('Ablauf für Practice')}}: {{ \Carbon\Carbon::parse($practice->date)->format('d.m.Y') }}
                - {{ $practice->topic }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="mb-4 text-xl font-bold text-gray-800 text-center">{{__('Schedule')}}</div>
                <table class="w-full table-auto">
                    <thead>
                    <tr class="text-center text-white bg-gray-800">
                        <th class="px-4 py-2">{{__('#')}}</th>
                        <th class="px-4 py-2">{{__('Exercise')}}</th>
                        <th class="px-4 py-2">{{__('Coaches')}}</th>
                        <th class="px-4 py-2">{{__('Player count')}}</th>
                        <th class="px-4 py-2">{{__('Goalkeeper count')}}</th>
                        <th class="px-4 py-2">{{__('Time')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($schedules as $schedule)
                        <tr>
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
        </div>
    </div>

    @foreach($schedules as $schedule)
        @php($exercise = Exercise::find($schedule->exercise_id))
        <div class="py-2">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <x-exercise-single :exercise="$exercise"></x-exercise-single>
            </div>
        </div>
    @endforeach
</x-app-layout>


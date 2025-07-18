@php use App\Models\Exercise; @endphp
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <x-back-button></x-back-button>
            <h2 class="ml-2 text-xl font-semibold text-gray-800 leading-tight">
                {{__('Practice')}}: {{ \Carbon\Carbon::parse($practice->date)->format('d.m.Y') }}
                - {{ $practice->topic }}
            </h2>
            <a href="{{ route('print', [$practice]) }}" target="_blank">
                <button class="ml-auto px-4 py-2 text-white bg-green-500 hover:bg-green-700 rounded-lg">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M17.5 12.75C18.1904 12.75 18.75 12.1904 18.75 11.5C18.75 10.8096 18.1904 10.25 17.5 10.25C16.8096 10.25 16.25 10.8096 16.25 11.5C16.25 12.1904 16.8096 12.75 17.5 12.75Z"
                            fill="white"/>
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M7 2C6.44772 2 6 2.44772 6 3V7H5C3.34315 7 2 8.34315 2 10V17C2 18.1046 2.89543 19 4 19H6V21C6 21.5523 6.44772 22 7 22H17C17.5523 22 18 21.5523 18 21V19H20C21.1046 19 22 18.1046 22 17V10C22 8.34315 20.6569 7 19 7H18V3C18 2.44772 17.5523 2 17 2H7ZM16 7V4H8V7H16ZM18 17H20V10C20 9.44772 19.5523 9 19 9H5C4.44772 9 4 9.44772 4 10L4 17H6V15C6 14.4477 6.44772 14 7 14H17C17.5523 14 18 14.4477 18 15V17ZM8 20V16H16V20H8Z"
                              fill="white"/>
                    </svg>

                </button>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <livewire:edit-practice :practice="$practice"/>
                <livewire:practice-schedule-builder :practice="$practice"/>
                <livewire:practice-ratings-table :practice="$practice"/>
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

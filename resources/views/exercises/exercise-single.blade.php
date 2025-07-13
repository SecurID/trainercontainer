<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <x-back-button></x-back-button>
            <h2 class="text-xl font-semibold text-gray-800 leading-tight">
                {{ $exercise->name }}
            </h2>
            <div>
                @if($exercise->user_id === auth()->id())
                    <a href="{{ route('exercises.edit', ['exercise' => $exercise]) }}" class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white rounded">
                        {{ __('Edit Exercise') }}
                    </a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white shadow-xl sm:rounded-lg">
            <x-exercise-single :exercise="$exercise"></x-exercise-single>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <x-back-button></x-back-button>
            <h2 class="text-xl font-semibold text-gray-800 leading-tight">
                {{ $exercise->name }}
            </h2>
            <div>
                <a href="{{ route('exercises.edit', ['exercise' => $exercise]) }}" class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white rounded">
                    {{ __('Edit Exercise') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="mb-3">
                    <div class="flex justify-center">
                        @if($exercise->image)
                            <img class="w-1/2 rounded-md" src="{{$exercise->image}}" alt="{{$exercise->name}}">
                        @endif
                    </div>
                    <div class="mt-4">
                        <h5 class="text-lg font-bold">{{$exercise->name}}</h5>
                        <hr class="my-2">
                        <div class="grid md:grid-cols-3 gap-4">
                            <div><b>{{ __('Procedure') }}:</b>
                                <pre class="font-sans text-wrap">{!! $exercise->procedure !!}</pre>
                            </div>
                            <div><b>{{ __('Coaching') }}:</b>
                                <pre class="font-sans text-wrap">{!! $exercise->coaching !!}</pre>
                            </div>
                            <div>
                                <p><b>{{ __('Duration') }}:</b> {{$exercise->duration}} {{__('minutes')}}<br>
                                    <b>{{ __('Intensity') }}:</b> {{$exercise->intensity}}%</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

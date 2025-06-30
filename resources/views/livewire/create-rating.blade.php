@php use Illuminate\Support\Carbon; @endphp
<div>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">
                {{ __('Ratings') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if($players->isEmpty())
                    <div
                        class="text-red-600">{{__('Keine Spieler gefunden.')}} {{ __('Bitte erstelle Spieler im "Players" Tab.') }}</div>
                @else
                    <form wire:submit.prevent="save">
                        <label for="practice"
                               class="block text-gray-700 text-sm font-bold mb-2">{{__('Trainingseinheit')}}</label>
                        <select wire:model="selectedPractice" id="practice" class="mb-4 w-full border rounded p-2">
                            @foreach($practices as $practice)
                                <option value="{{ $practice->id }}">
                                    {{ Carbon::parse($practice->date)->locale(app()->getLocale())->translatedFormat('l') }}
                                    - {{ Carbon::parse($practice->date)->format('d.m.Y') }}
                                    - {{ $practice->topic }}                                </option>
                            @endforeach
                        </select>
                        <hr class="my-4">
                        @foreach($players as $player)
                            <div class="flex justify-between items-center py-2">
                                <div>
                                    {{ $player->prename }} {{ $player->lastname }}
                                </div>
                                <x-rating-form :player="$player"/>
                            </div>
                            <hr class="my-2">
                        @endforeach
                        <div class="flex justify-end mt-4">
                            <button type="submit"
                                    class="px-4 py-2 bg-green-600 text-white font-bold rounded hover:bg-green-700">
                                {{__('Speichern')}}
                            </button>
                        </div>
                    </form>
                @endif
                @if (session()->has('success'))
                    <div class="mt-4 text-green-600">{{ session('success') }}</div>
                @endif
            </div>
        </div>
    </div>
</div>

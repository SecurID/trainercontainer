@php use Illuminate\Support\Carbon; @endphp
<div>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <flux:heading size="xl">
                {{ __('Ratings') }}
            </flux:heading>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if($players->isEmpty())
                    <flux:text class="text-red-600">
                        {{ __('Keine Spieler gefunden.') }} {{ __('Bitte erstelle Spieler im "Players" Tab.') }}
                    </flux:text>
                @else
                    <form wire:submit.prevent="save">
                        <flux:field class="mb-4">
                            <flux:label>{{ __('Trainingseinheit') }}</flux:label>
                            <flux:select wire:model="selectedPractice">
                                @foreach($practices as $practice)
                                    <flux:select.option value="{{ $practice->id }}">
                                        {{ Carbon::parse($practice->date)->locale(app()->getLocale())->translatedFormat('l') }}
                                        - {{ Carbon::parse($practice->date)->format('d.m.Y') }}
                                        - {{ $practice->topic }}
                                    </flux:select.option>
                                @endforeach
                            </flux:select>
                        </flux:field>

                        <flux:separator class="my-4" />

                        @foreach($players as $player)
                            <div class="flex justify-between items-center py-2">
                                <flux:text>{{ $player->prename }} {{ $player->lastname }}</flux:text>
                                <x-rating-form :player="$player"/>
                            </div>
                            <flux:separator class="my-2" />
                        @endforeach

                        <div class="flex justify-end mt-4">
                            <flux:button type="submit" variant="primary">
                                {{ __('Speichern') }}
                            </flux:button>
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

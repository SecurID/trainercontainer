<x-app-layout>
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
                <form method="POST" action="/ratings">
                    @csrf
                    <div class="relative max-w-sm">
                        <x-bladewind::datepicker  placeholder="{{__('Select Date')}}"/>
                    </div>
                    <hr class="my-4">
                    @foreach($players as $player)
                        <div class="flex justify-between items-center py-2">
                            <div>
                                {{ $player->prename }} {{ $player->lastname }}
                            </div>
                            <div class="flex">
                                <div class="space-x-2">
                                    <x-rating-form :player="$player" />
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="flex justify-end mt-4">
                        <button type="submit"
                                class="px-4 py-2 bg-green-600 text-white font-bold rounded hover:bg-green-700">
                            {{__('Save')}}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

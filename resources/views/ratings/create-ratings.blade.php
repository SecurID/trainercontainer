<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="text-xl font-semibold text-gray-800 leading-tight">
                {{ __('Ratings') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form method="POST" action="/ratings">
                    @csrf
                    <div class="flex justify-between mb-4">
                        <div>
                            <b>Datum</b>
                        </div>
                        <div>
                            <input type="date" name="date" class="form-input rounded-md shadow-sm border-gray-300" value="<?php echo date('Y-m-d'); ?>" />
                        </div>
                    </div>
                    <hr class="my-4">
                    @foreach($players as $player)
                        <div class="flex justify-between items-center py-2">
                            <div>
                                {{ $player->prename }} {{ $player->lastname }}
                            </div>
                            <div class="flex">
                                <!-- Tailwind CSS does not have a direct equivalent for btn-group, so custom styles or a component library like Tailwind UI may be needed for exact styling -->
                                <div class="space-x-2">
                                    <label class="inline-flex items-center px-3 py-1 rounded bg-red-600 text-white cursor-pointer">
                                        <input type="radio" name="rating{{$player->id}}" class="hidden" autocomplete="off" value="1"> --
                                    </label>
                                    <label class="inline-flex items-center px-3 py-1 rounded bg-red-600 text-white cursor-pointer">
                                        <input type="radio" name="rating{{$player->id}}" class="hidden" autocomplete="off" value="2"> -
                                    </label>
                                    <label class="inline-flex items-center px-3 py-1 rounded bg-yellow-500 text-white cursor-pointer">
                                        <input type="radio" name="rating{{$player->id}}" class="hidden" autocomplete="off" value="3" checked> o
                                    </label>
                                    <label class="inline-flex items-center px-3 py-1 rounded bg-blue-600 text-white cursor-pointer">
                                        <input type="radio" name="rating{{$player->id}}" class="hidden" autocomplete="off" value="4"> +
                                    </label>
                                    <label class="inline-flex items-center px-3 py-1 rounded bg-blue-600 text-white cursor-pointer">
                                        <input type="radio" name="rating{{$player->id}}" class="hidden" autocomplete="off" value="5"> ++
                                    </label>
                                    <label class="inline-flex items-center px-3 py-1 rounded bg-gray-500 text-white cursor-pointer">
                                        <input type="radio" name="rating{{$player->id}}" class="hidden" autocomplete="off" value="0"> NA
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="flex justify-end mt-4">
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white font-bold rounded hover:bg-green-700">
                            {{__('Save')}}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="text-xl font-semibold text-gray-800 leading-tight">
                {{ __('Ratings') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form method="POST" action="/ratings">
                    @csrf
                    <div class="flex justify-between mb-4">
                        <div>
                            <b>Datum</b>
                        </div>
                        <div>
                            <input type="date" name="date" class="form-input rounded-md shadow-sm border-gray-300" value="<?php echo date('Y-m-d'); ?>" />
                        </div>
                    </div>
                    <hr class="my-4">
                    @foreach($players as $player)
                        <div class="flex justify-between items-center py-2">
                            <div>
                                {{ $player->prename }} {{ $player->lastname }}
                            </div>
                            <div class="flex">
                                <!-- Tailwind CSS does not have a direct equivalent for btn-group, so custom styles or a component library like Tailwind UI may be needed for exact styling -->
                                <div class="space-x-2">
                                    <label class="inline-flex items-center px-3 py-1 rounded bg-red-600 text-white cursor-pointer">
                                        <input type="radio" name="rating{{$player->id}}" class="hidden" autocomplete="off" value="1"> --
                                    </label>
                                    <label class="inline-flex items-center px-3 py-1 rounded bg-red-600 text-white cursor-pointer">
                                        <input type="radio" name="rating{{$player->id}}" class="hidden" autocomplete="off" value="2"> -
                                    </label>
                                    <label class="inline-flex items-center px-3 py-1 rounded bg-yellow-500 text-white cursor-pointer">
                                        <input type="radio" name="rating{{$player->id}}" class="hidden" autocomplete="off" value="3" checked> o
                                    </label>
                                    <label class="inline-flex items-center px-3 py-1 rounded bg-blue-600 text-white cursor-pointer">
                                        <input type="radio" name="rating{{$player->id}}" class="hidden" autocomplete="off" value="4"> +
                                    </label>
                                    <label class="inline-flex items-center px-3 py-1 rounded bg-blue-600 text-white cursor-pointer">
                                        <input type="radio" name="rating{{$player->id}}" class="hidden" autocomplete="off" value="5"> ++
                                    </label>
                                    <label class="inline-flex items-center px-3 py-1 rounded bg-gray-500 text-white cursor-pointer">
                                        <input type="radio" name="rating{{$player->id}}" class="hidden" autocomplete="off" value="0"> NA
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="flex justify-end mt-4">
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white font-bold rounded hover:bg-green-700">
                            {{__('Save')}}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

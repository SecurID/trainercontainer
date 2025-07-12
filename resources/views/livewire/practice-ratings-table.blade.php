<div>
    <div class="mb-4 text-xl font-bold text-gray-800 text-center">Spielerbewertungen</div>
    <table class="w-full table-auto">
        <thead>
        <tr class="text-center text-white bg-gray-800">
            <th class="px-4 py-2">#</th>
            <th class="px-4 py-2">Name</th>
            <th class="px-4 py-2">Bewertung</th>
        </tr>
        </thead>
        <tbody>
        @foreach($players as $index => $player)
            <tr>
                <td class="px-4 py-2 text-center">{{ $index + 1 }}</td>
                <td class="px-4 py-2">{{ $player->getFullname() }}</td>
                <td class="px-4 py-2 text-center">
                    <div class="grid grid-cols-2 items-center space-y-1">
                        <div class="flex items-center space-x-2">
                            @for($i = 1; $i <= 5; $i++)
                                <label>
                                    <input type="radio" wire:model="ratings.{{ $player->id }}" value="{{ $i }}" @if(isset($attendances[$player->id]) && $attendances[$player->id] === true) disabled @endif>
                                    <span>{{ $i }}</span>
                                </label>
                            @endfor
                        </div>
                        <label class="flex items-center space-x-1 mt-1">
                            <input type="checkbox" wire:model="attendances.{{ $player->id }}" value="1"
                                x-on:change="if($event.target.checked){ $wire.set('ratings.{{ $player->id }}', null) }">
                            <span>Nicht anwesend</span>
                        </label>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="mt-4">
        @if($success)
            <div class="mb-2 p-2 bg-green-100 text-green-800 rounded text-center">
                Bewertungen wurden erfolgreich gespeichert!
            </div>
        @endif
        <button wire:click="saveRatings"
                class="w-full px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400">
            Bewertungen speichern
        </button>
    </div>
</div>

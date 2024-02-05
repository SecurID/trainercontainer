<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Players') }}
                </h2>
            </div>
            <div class="col">
                <div class="float-right">
                    <a href="/players/create"><button class="btn btn-primary">{{ __('Create Player') }}</button></a>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="list-group">
                    @foreach($players as $player)
                        <a href="{{ route('players.show', $player->id) }}" class="list-group-item list-group-item-action">{{$player->prename}} {{$player->lastname}}</a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>




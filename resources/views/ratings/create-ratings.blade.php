<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Create Ratings') }}
                </h2>
            </div>
        </div>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <form method="POST" action="/ratings">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <b>Datum</b>
                        </div>
                        <div class="col">
                            <input type="date" name="date" value="<?php echo date('Y-m-d'); ?>" />
                        </div>
                    </div>
                    <hr>
                    @foreach($players as $player)
                    <div class="row">
                        <div class="col">
                            {{ $player->prename }} {{$player->name}}
                        </div>
                        <div class="col">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="rating{{$player->id}}" id="inlineRadio1" value="1">
                                <label class="form-check-label" for="inlineRadio1">--</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="rating{{$player->id}}" id="inlineRadio2" value="2">
                                <label class="form-check-label" for="inlineRadio2">-</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="rating{{$player->id}}" id="inlineRadio3" value="3" checked="checked">
                                <label class="form-check-label" for="inlineRadio3">o</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="rating{{$player->id}}" id="inlineRadio4" value="4">
                                <label class="form-check-label" for="inlineRadio4">+</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="rating{{$player->id}}" id="inlineRadio5" value="5">
                                <label class="form-check-label" for="inlineRadio5">++</label>
                            </div>
                            <div class="form-check form-check-inline ml-3 bg-warning">
                                <input class="form-check-input" type="radio" name="rating{{$player->id}}" id="inlineRadio5" value="99">
                                <label class="form-check-label" for="inlineRadio5">n.a.</label>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <div class="row">
                        <div class="col">
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-success">Create Ratings</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

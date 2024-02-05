<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Ratings') }}
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
                            {{ $player->prename }} {{$player->lastname}}
                        </div>
                        <div class="col">
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-danger">
                                    <input type="radio" name="rating{{$player->id}}" id="option1" autocomplete="off" value="1"> --
                                </label>
                                <label class="btn btn-danger">
                                    <input type="radio" name="rating{{$player->id}}" id="option2" autocomplete="off" value="2"> -
                                </label>
                                <label class="btn btn-warning active">
                                    <input type="radio" name="rating{{$player->id}}" id="option3" autocomplete="off" value="3" checked> o
                                </label>
                                <label class="btn btn-primary">
                                    <input type="radio" name="rating{{$player->id}}" id="option4" autocomplete="off" value="4"> +
                                </label>
                                <label class="btn btn-primary">
                                    <input type="radio" name="rating{{$player->id}}" id="option5" autocomplete="off" value="5"> ++
                                </label>
                                <label class="btn btn-secondary">
                                    <input type="radio" name="rating{{$player->id}}" id="option6" autocomplete="off" value="0"> NA
                                </label>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <div class="row">
                        <div class="col">
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-success">{{__('Save')}}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

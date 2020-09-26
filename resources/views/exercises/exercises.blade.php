<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Excercises') }}
            </h2>
            </div>
            <div class="col">
            <div class="float-right">
                <a href="/exercises/create"><button class="btn btn-primary">Create Exercise</button></a>
            </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <ul class="nav nav-tabs" id="myTab" role="tablist" style="margin-bottom: 20px;">
                    <li class="nav-item">
                        <a class="nav-link active" id="all-tab" data-toggle="tab" href="#all" role="tab" aria-controls="all" >All</a>
                    </li>
                    @foreach($categories as $category)
                    <li class="nav-item">
                        <a class="nav-link" id="{{$category->name}}-tab" data-toggle="tab" href="#{{$category->name}}" role="tab" aria-controls="{{$category->name}}" >{{$category->name}}</a>
                    </li>
                    @endforeach
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
                        <div class="card-deck">
                            @foreach ($exercises as $exercise)
                                <!--<div style="width: 33%!important;">-->
                                    <div class="card">
                                        <img class="card-img-top" src="{{$exercise->image}}" alt="{{$exercise->name}}">
                                        <div class="card-body">
                                            <h5 class="card-title">{{$exercise->name}}</h5>
                                            <a class="stretched-link" href="{{ route('exercises.show', $exercise->id) }}"></a>
                                        </div>
                                        <div class="card-footer">
                                            <small class="text-muted">Duration: {{$exercise->duration}} min. | Intensity: {{$exercise->intensity}}%</small>
                                        </div>
                                    </div>
                                @if ($loop->iteration % 7 == 0)
                                </div>
                                <div class="card-deck pt-6" >
                                @endif
                            @endforeach
                        </div>
                    </div>
                    @foreach($categories as $category)
                        <div class="tab-pane fade" id="{{$category->name}}" role="tabpanel" aria-labelledby="{{$category->name}}-tab">

                        </div>
                    @endforeach
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ $exercise->name }}
                </h2>
            </div>
            <div class="col">
                <div class="float-right">
                    <a href="/exercises/edit"><button class="btn btn-primary">{{__('Edit Exercise')}}</button></a>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="card mb-3">
                    <div class="d-flex justify-content-center"><img class="card-img-top w-50 " src="{{$exercise->image}}" alt="{{$exercise->name}}"></div>
                    <div class="card-body">
                        <h5 class="card-title">{{$exercise->name}}</h5>
                        <hr>
                        <div class="row">
                            <div class="col"><b>{{__('Procedure')}}:</b> <p class="card-text">{!! $exercise->procedure!!}</p></div>
                            <div class="col"><b>{{__('Coaching')}}:</b><p class="card-text">{!! $exercise->coaching !!}</p></div>
                            <div class="col"><p class="card-text"><b>{{__('Duration')}}:</b> &nbsp;&nbsp;&nbsp;{{$exercise->duration}} <br> <b>{{__('Intensity')}}:</b> &nbsp;&nbsp;&nbsp;{{$exercise->intensity}}%</p></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

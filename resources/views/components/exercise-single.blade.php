<div class="bg-white overflow-hidden p-6">
    <div class="mb-3">
        <div class="flex justify-between">
            <h5 class="text-2xl"><span class="font-bold">{{$exercise->name}}</span></h5>
            <p class="text-lg">{{__('Focus')}}: {{$exercise->focus}}</p>
        </div>
        @if($exercise->image)
            <div class="flex justify-center">
                <img class="w-1/2 rounded-md" src="{{ asset('storage/' . $exercise->image) }}" alt="{{$exercise->name}}">
            </div>
        @endif
        <div class="mt-4">
            <hr class="my-2">
            <div class="grid md:grid-cols-3 gap-4">
                <div><b>{{ __('Procedure') }}:</b>
                    <pre class="font-sans text-wrap">{!! $exercise->procedure !!}</pre>
                </div>
                <div><b>{{ __('Coaching') }}:</b>
                    <pre class="font-sans text-wrap">{!! $exercise->coaching !!}</pre>
                </div>
                <div>
                    <p><b>{{ __('Duration') }}:</b> {{$exercise->duration}} {{__('minutes')}}<br>
                        <b>{{ __('Intensity') }}:</b> {{$exercise->intensity}}%</p>
                    <b>{{__('Material')}}:</b> {{$exercise->material}}</p>
                </div>
            </div>
        </div>
    </div>
</div>

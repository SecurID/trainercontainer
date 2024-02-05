<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Practices') }}
                </h2>
            </div>
            <div class="col">
                <div class="float-right">
                    <a href="/practices/create"><button class="btn btn-primary">{{ __('Create Practice') }}</button></a>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <table>
                    <thead>
                        <th>{{__('Date')}}</th>
                    </thead>
                    @foreach($practices as $practice)
                        <tr>
                            <td><a href="{{ route('practices.show', $practice->id) }}">{{\Carbon\Carbon::parse($practice->date)->format('d.m.Y')}}</a></td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</x-app-layout>

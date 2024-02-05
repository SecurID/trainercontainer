<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Create Practice') }}
                </h2>
            </div>
        </div>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="row">
                        <div class="col">
                            {{__('Datum')}}<input type="date" class="form-control" placeholder="Datum" name="date" id="date">
                        </div>
                    </div>
                    <!-- Editable table -->
                    <div class="card">
                        <h3 class="card-header text-center font-weight-bold text-uppercase py-4">{{__('Schedule')}}</h3>
                        <div class="card-body">
                            <div id="table" class="table-editable">
                                <table class="table table-bordered table-responsive-md table-striped text-center">
                                    <thead>
                                    <tr>
                                        <th class="text-center">{{__('#')}}</th>
                                        <th class="text-center">{{__('Exercise')}}</th>
                                        <th class="text-center">{{__('Coaches')}}</th>
                                        <th class="text-center">{{__('Player count')}}</th>
                                        <th class="text-center">{{__('Goalkeeper count')}}</th>
                                        <th class="text-center">{{__('Time')}}</th>
                                        <th class="text-center">{{__('Delete row')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="pt-3-half" contenteditable="true"></td>
                                        <td class="pt-3-half exercises" contenteditable="true" ></td>
                                        <td class="pt-3-half" contenteditable="true"></td>
                                        <td class="pt-3-half" contenteditable="true"></td>
                                        <td class="pt-3-half" contenteditable="true"></td>
                                        <td class="pt-3-half" contenteditable="true"></td>
                                        <td>
                                            <span class="table-remove"><button type="button" class="btn btn-danger btn-rounded btn-sm my-0">X</button></span>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <span class="table-add float-right mb-3 mr-2"><a href="#!" class="text-success"><i class="fas fa-plus fa-2x" aria-hidden="true">{{__('Add row')}}</i></a></span>
                            </div>
                        </div>
                    </div>
                    <!-- Editable table -->
                    <div class="row">
                        <div class="col">
                            <div class="d-flex justify-content-end">
                                <button class="btn btn-success" id="export-btn">{{ __('Create Practice') }}</button>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
    @push('jsscripts')
    <script src="{{ asset('js/table-editable.js') }}" ></script>
    <script src="{{ asset('js/exercise-autocomplete.js') }}" ></script>
    @endpush
</x-app-layout>

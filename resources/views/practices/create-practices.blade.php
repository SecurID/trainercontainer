<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="text-xl font-semibold text-gray-800 leading-tight">
                {{ __('Create Practice') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="mb-4">
                    <label for="date" class="block text-gray-700 text-sm font-bold mb-2">{{__('Datum')}}</label>
                    <input type="date" class="form-input rounded-md shadow-sm w-full" placeholder="Datum" name="date" id="date">
                </div>
                <div class="card bg-white">
                    <h3 class="card-header text-center font-bold text-xl text-gray-800 py-4">{{__('Schedule')}}</h3>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped text-center">
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
                                    <td class="pt-3" contenteditable="true"></td>
                                    <td class="pt-3 exercises" contenteditable="true"></td>
                                    <td class="pt-3" contenteditable="true"></td>
                                    <td class="pt-3" contenteditable="true"></td>
                                    <td class="pt-3" contenteditable="true"></td>
                                    <td class="pt-3" contenteditable="true"></td>
                                    <td>
                                        <button type="button" class="py-1 px-3 bg-red-500 text-white rounded hover:bg-red-700 transition duration-300">X</button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="flex justify-end">
                                <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-300">
                                    {{ __('Create Practice') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Create Practice') }}
            </h2>
        </div>
    </x-slot>
    <div x-data="tableManager()" class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="grid grid-cols-2 gap-4 mb-4 justify-between">
                    <div>
                        <label for="date" class="text-sm font-bold text-gray-700">{{__('Datum')}}</label>
                        <x-datepicker name="date"></x-datepicker>
                    </div>
                    <div>
                        <label for="topic" class="text-sm font-bold text-gray-700">{{__('Topic')}}</label>
                        <div>
                        <input type="text" id="topic" name="topic" class="w-full px-3 py-2 border border-gray-300 rounded-md" placeholder="{{__('1 on 1')}}">
                        </div>
                    </div>
                </div>
                <div>
                    <h3 class="py-4 text-center text-xl font-bold text-gray-800">{{__('Schedule')}}</h3>
                    <table class="w-full table-auto">
                        <thead>
                        <tr class="text-center text-white bg-gray-800">
                            <th class="px-4 py-2">{{__('#')}}</th>
                            <th class="px-4 py-2">{{__('Exercise')}}</th>
                            <th class="px-4 py-2">{{__('Coaches')}}</th>
                            <th class="px-4 py-2">{{__('Player count')}}</th>
                            <th class="px-4 py-2">{{__('Goalkeeper count')}}</th>
                            <th class="px-4 py-2">{{__('Time')}}</th>
                            <th class="px-4 py-2">{{__('Delete row')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <template x-for="(row, index) in rows" :key="index">
                            <tr class="border-b border-gray-200">
                                <td class="px-4 py-2 text-center" x-text="index + 1"></td>
                                <td class="px-4 py-2" contenteditable="true" x-text="row.exercise"></td>
                                <td class="px-4 py-2" contenteditable="true" x-text="row.coaches"></td>
                                <td class="px-4 py-2" contenteditable="true" x-text="row.playerCount"></td>
                                <td class="px-4 py-2" contenteditable="true" x-text="row.goalkeeperCount"></td>
                                <td class="px-4 py-2" contenteditable="true" x-text="row.time"></td>
                                <td class="px-4 py-2 text-center">
                                    <button type="button" @click="removeRow(index)" class="py-1 px-3 text-white bg-red-500 rounded hover:bg-red-700 transition duration-300">X</button>
                                </td>
                            </tr>
                        </template>
                        </tbody>
                    </table>
                    <div class="flex justify-between mt-4">
                        <button @click="addRow" class="py-2 px-4 bg-blue-500 text-white rounded hover:bg-blue-700 transition duration-300">
                            {{ __('Add row') }}
                        </button>
                        <button type="submit" class="py-2 px-4 bg-blue-500 text-white rounded hover:bg-blue-700 transition duration-300">
                            {{ __('Create Practice') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    function tableManager() {
        return {
            rows: [],
            addRow() {
                this.rows.push({ exercise: '', coaches: '', playerCount: '', goalkeeperCount: '', time: '' });
            },
            removeRow(index) {
                this.rows.splice(index, 1);
            }
        }
    }
</script>

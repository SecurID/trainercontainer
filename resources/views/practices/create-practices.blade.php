<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Create Practice') }}
            </h2>
        </div>
    </x-slot>
    <div x-data="tableManager()" x-init="init()" class="py-12">
        <form @submit.prevent="handleSubmit">
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
                                <input type="text" id="topic" name="topic"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md"
                                       placeholder="{{__('1 on 1')}}">
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
                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                    <td class="px-4 py-3 text-center text-sm font-medium" x-text="index + 1"></td>
                                    <td class="px-4 py-3 exercise exercises bg-gray-100 rounded cursor-text shadow-sm"
                                        contenteditable="true" x-text="row.exercise"></td>
                                    <td class="hidden exerciseId" x-text="row.exerciseId"></td>
                                    <td class="px-4 py-3 coaches bg-gray-100 rounded cursor-text shadow-sm"
                                        contenteditable="true"
                                        x-text="row.coaches"></td>
                                    <td class="px-4 py-3 playerCount bg-gray-100 rounded cursor-text shadow-sm"
                                        contenteditable="true"
                                        x-text="row.playerCount"></td>
                                    <td class="px-4 py-3 goalkeeperCount bg-gray-100 rounded cursor-text shadow-sm"
                                        contenteditable="true"
                                        x-text="row.goalkeeperCount"></td>
                                    <td class="px-4 py-3 time bg-gray-100 rounded cursor-text shadow-sm"
                                        contenteditable="true"
                                        x-text="row.time"></td>
                                    <td class="px-4 py-3 text-center">
                                        <button type="button" @click="removeRow(index)"
                                                class="py-2 px-4 text-white bg-red-600 rounded hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 transition duration-300">
                                            X
                                        </button>
                                    </td>
                                </tr>
                            </template>
                            </tbody>
                        </table>
                        <div class="flex justify-between mt-4">
                            <button @click="addRow"
                                    type="button"
                                    class="py-2 px-4 bg-blue-500 text-white rounded hover:bg-blue-700 transition duration-300">
                                {{ __('Add row') }}
                            </button>
                            <button type="submit"
                                    class="py-2 px-4 bg-blue-500 text-white rounded hover:bg-blue-700 transition duration-300">
                                {{ __('Create Practice') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

</x-app-layout>

<script>
    function tableManager() {
        return {
            rows: [],
            initAutocomplete() {
                this.$nextTick(() => {
                    $('.exercises').each((i, el) => {
                        $(el).autocomplete({
                            source: function (request, response) {
                                $.ajax({
                                    url: "api/exercises",
                                    data: {term: request.term},
                                    dataType: "json",
                                    success: function (data) {
                                        response($.map(data, function (obj) {
                                            return {
                                                label: obj.name, // What's shown in the autocomplete suggestions
                                                value: obj.name, // What's filled in the input when selected
                                                id: obj.id // The actual value you want to capture
                                            };
                                        }));
                                    }
                                });
                            },
                            minLength: 2,
                            select: (event, ui) => {
                                // Use a data attribute to find the corresponding row
                                const rowIndex = $(el).data('row-index');
                                if (this.rows[rowIndex] !== undefined) {
                                    this.rows[rowIndex].exercise = ui.item.value;
                                    this.rows[rowIndex].exerciseId = ui.item.id;
                                    // Ensure Alpine.js reactivity
                                    this.$dispatch('input', {value: ui.item.value});
                                }
                                event.preventDefault(); // Prevent default autocomplete behavior
                                $(el).text(ui.item.value); // Set the selected text
                            },
                        });
                    });
                });
            },
            addRow() {
                const rowIndex = this.rows.length;
                this.rows.push({
                    exercise: '',
                    exerciseId: '',
                    coaches: '',
                    playerCount: '',
                    goalkeeperCount: '',
                    time: ''
                });
                this.initAutocomplete();
                this.$nextTick(() => {
                    // Set the data attribute for the new row's exercise input
                    document.querySelectorAll('.exercises').forEach((el, index) => {
                        el.setAttribute('data-row-index', index);
                    });
                });
            },
            removeRow(index) {
                this.rows.splice(index, 1);
            },
            init() {
                this.initAutocomplete(); // Initial setup
            },
            handleSubmit() {
                // Collect data
                console.log('submit');
                const data = {
                    date: document.querySelector('input[name="date"]').value,
                    topic: document.querySelector('input[name="topic"]').value,
                    rows: this.rows.map((row, index) => {
                        // Find each row in the DOM
                        const rowElement = document.querySelectorAll('tr.border-b.border-gray-200')[index];
                        // Capture content from contenteditable divs
                        return {
                            ...row,
                            exercise: rowElement.querySelector('.exercise').textContent,
                            exerciseId: rowElement.querySelector('.exerciseId').textContent,
                            coaches: rowElement.querySelector('[contenteditable].coaches').textContent,
                            playerCount: rowElement.querySelector('[contenteditable].playerCount').textContent,
                            goalkeeperCount: rowElement.querySelector('[contenteditable].goalkeeperCount').textContent,
                            time: rowElement.querySelector('[contenteditable].time').textContent,
                        };
                    })
                };

                console.log(JSON.stringify(data))

                // Send data to the server using Fetch API
                fetch('{{ route('practices.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // For CSRF token verification
                    },
                    body: JSON.stringify(data),
                })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Success:', data);
                        // redirect to practices.index route
                        window.location = '{{ route('practices.index') }}';
                    })
                    .catch((error) => {
                        alert("{{ __('Please fill out at least the topic!') }}")
                    });
            }
        }
    }
</script>


<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <x-back-button></x-back-button>
            <h2 class="text-xl font-semibold text-gray-800 leading-tight">
                {{ __('Create Exercise') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form method="POST" action="/exercises" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <input type="text" class="form-input rounded-md shadow-sm w-full" placeholder="{{ __('Name') }}"
                               name="name">
                        <input type="text" class="form-input rounded-md shadow-sm w-full"
                               placeholder="{{ __('Focus') }}" name="focus">
                    </div>
                    <!-- Multiple categories selection -->
                    <div class="grid grid-cols-1 mb-4 w-full">
                        <select name="categories[]"
                                class="form-input rounded-md shadow-sm w-full text-gray-500 js-select-multiple"
                                multiple>
                            <option disabled>{{ __('Choose Categories') }}</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ __($category->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-4">
                        <input type="text" class="form-input rounded-md shadow-sm w-full"
                               placeholder="{{ __('Material') }}" name="material">
                        <input type="text" class="form-input rounded-md shadow-sm w-full"
                               placeholder="{{ __('Duration') }}" name="duration">
                        <input type="text" class="form-input rounded-md shadow-sm w-full mr-2"
                               placeholder="{{ __('Intensity') }}" name="intensity">
                    </div>
                    <div class="grid grid-cols-1 lg:grid-cols-4 gap-4 mb-4">
                        <input type="number" class="form-input rounded-md shadow-sm w-full mr-2"
                               placeholder="{{ __('Player count') }}" name="playerCount">
                        <input type="number" class="form-input rounded-md shadow-sm w-full mr-2"
                               placeholder="{{ __('Goalkeeper count') }}" name="goalkeeperCount">
                        <select name="level"
                                class="form-input rounded-md shadow-sm w-full text-gray-500"
                                >
                            <option>{{ __('Choose Level') }}</option>
                            <option value="1">{{ __('Beginner') }}</option>
                            <option value="2">{{ __('Intermediate') }}</option>
                            <option value="3">{{ __('Advanced') }}</option>
                            <option value="4">{{ __('Expert') }}</option>
                        </select>
                        <input type="number" class="form-input rounded-md shadow-sm w-full mr-2"
                               placeholder="{{ __('From Age') }}" name="age">
                    </div>
                    <textarea class="form-input rounded-md shadow-sm w-full mb-4" placeholder="{{ __('Procedure') }}"
                              name="procedure"></textarea>
                    <textarea class="form-input rounded-md shadow-sm w-full mb-4" placeholder="{{ __('Coaching') }}"
                              name="coaching"></textarea>
                    <div class="md:flex block items-center mb-4">
                        <label for="drawing" class="block text-md font-bold text-gray-500 mr-4 mb-2">
                            {{ __('Drawing') }}
                        </label>
                        <input type="file"
                               class="form-input rounded-md shadow-sm border-[1px] border-gray-500 w-full text-gray-500"
                               name="drawing">
                    </div>
                    <div class="flex justify-end">
                        <button type="submit"
                                class="px-4 py-2 bg-green-500 hover:bg-green-700 text-white font-bold rounded">
                            {{ __('Create Exercise') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function () {
                $('.js-select-multiple').select2({
                    placeholder: "{{ __('Choose Categories') }}",
                });
            });
        </script>
    @endpush
    @push('styles')
        <style>
            /* Base styling for the Select2 container */
            .select2-container .select2-selection--multiple {
                border: 1px solid #6B7280; /* Tailwind's border-gray-300 */
                border-radius: 0.375rem; /* Tailwind's rounded-md */
                padding: 0.125rem 0.125rem 0.5rem;
                background-color: white; /* Tailwind's bg-white */
                box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06); /* Tailwind's shadow-sm */
            }

            /* Styling for the search field within Select2 */
            .select2-container--default .select2-search--inline .select2-search__field {
                border: none; /* Removes default border */
                outline: none; /* Removes default outline */
                box-shadow: none; /* Removes default shadow */
                font-size: 1rem; /* Tailwind's text-base */
                color: #6B7280; /* Tailwind's text-gray-700 */
                padding-left: 0.375rem;
                font-family: Nunito, ui-sans-serif, system-ui, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
                height: 24px;
            }

            /* Style adjustments for the Select2 choices/tags */
            .select2-container--default .select2-selection--multiple .select2-selection__choice {
                background-color: #edf2f7; /* Tailwind's bg-gray-200 */
                border: none; /* Removes default border */
                border-radius: 0.375rem; /* Tailwind's rounded-md */
                padding: 0.5rem 1.25rem; /* Adjust padding */
                color: #6B7280; /* Tailwind's text-gray-700 */
                font-size: 0.75rem; /* Tailwind's text-sm */
            }

            /* Focus and hover states */
            .select2-container--default .select2-selection--multiple:focus, .select2-container--default.select2-container--focus .select2-selection--multiple, .select2-container--default .select2-selection--multiple:hover {
                border-color: #a0aec0; /* Tailwind's border-gray-400 for focus/hover */
                box-shadow: 0 0 0 1px #a0aec0; /* Tailwind's shadow-outline */
            }

            /* Placeholder text color */
            .select2-container--default .select2-selection--multiple .select2-search__field::placeholder {
                color: #6B7280; /* Tailwind's text-gray-400 */
            }

            /* Adjusting the dropdown to match the input field styles */
            .select2-dropdown {
                border-radius: 0.375rem; /* Tailwind's rounded-md */
                border-color: #e2e8f0; /* Tailwind's border-gray-200 */
                box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06); /* Tailwind's shadow */
            }

            .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
                top: auto;
            }

        </style>
    @endpush
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
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
                        <input type="text" class="form-input rounded-md shadow-sm w-full" placeholder="{{ __('Name') }}" name="name">
                        <input type="text" class="form-input rounded-md shadow-sm w-full" placeholder="{{ __('Focus') }}" name="focus">
                    </div>
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-4">
                        <input type="text" class="form-input rounded-md shadow-sm w-full lg:col-span-2" placeholder="{{ __('Material') }}" name="material">
                        <input type="text" class="form-input rounded-md shadow-sm w-full" placeholder="{{ __('Duration') }}" name="duration">
                    </div>
                    <div class="flex mb-4">
                        <input type="text" class="form-input rounded-md shadow-sm w-full mr-2" placeholder="{{ __('Intensity') }}" name="intensity">
                        <span class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">%</span>
                    </div>
                    <textarea class="form-input rounded-md shadow-sm w-full mb-4" placeholder="{{ __('Procedure') }}" name="procedure"></textarea>
                    <textarea class="form-input rounded-md shadow-sm w-full mb-4" placeholder="{{ __('Coaching') }}" name="coaching"></textarea>
                    <div class="flex items-center mb-4">
                        <label class="block text-sm font-medium text-gray-700 mr-4">
                            {{ __('Drawing') }}
                        </label>
                        <input type="file" class="form-input rounded-md shadow-sm w-full" name="drawing">
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-green-500 hover:bg-green-700 text-white font-bold rounded">
                            {{ __('Create Exercise') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

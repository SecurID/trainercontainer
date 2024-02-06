<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="text-xl font-semibold text-gray-800 leading-tight">
                {{ __('Create Player') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form method="POST" action="/players" class="space-y-4">
                    @csrf
                    <div class="flex flex-wrap -mx-2">
                        <div class="w-full md:w-1/2 px-2 mb-4">
                            <input type="text" class="form-input rounded-md shadow-sm w-full" placeholder="{{ __('Pre name') }}" name="prename">
                        </div>
                        <div class="w-full md:w-1/2 px-2 mb-4">
                            <input type="text" class="form-input rounded-md shadow-sm w-full" placeholder="{{ __('Last name') }}" name="lastname">
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-green-500 hover:bg-green-700 text-white font-bold rounded">
                            {{ __('Create Player') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

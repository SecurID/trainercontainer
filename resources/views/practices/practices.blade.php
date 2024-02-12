<x-app-layout>
    <x-slot name="header">
        <div class="lg:flex sm:space-y-2 justify-between block">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Practices') }}
            </h2>
            <div class="flex space-x-2">
                <div>
                    <a>
                        <button class="px-4 py-2 text-white bg-green-500 hover:bg-green-700 rounded-lg" disabled>
                            {{ __('Generate AI Practice') }}
                        </button>
                    </a>
                </div>
                <div>
                    <a href="{{ route('practices.create') }}">
                        <button class="px-4 py-2 text-white bg-blue-500 hover:bg-blue-700 rounded-lg">
                            {{ __('Create Practice') }}
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                <table class="w-full">
                    <thead class="border-b">
                    <tr><th class="pb-2 text-left">{{__('Choose a Practice to view')}}</th></tr>
                    </thead>
                    <tbody>
                    @foreach($practices as $practice)
                        <tr class="border-b">
                            <td class="py-2">
                                <a href="{{ route('practices.show', $practice->id) }}" class="text-blue-600 hover:text-blue-800">
                                    {{ \Carbon\Carbon::parse($practice->date)->format('d.m.Y') }} - {{ $practice->topic }}
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>

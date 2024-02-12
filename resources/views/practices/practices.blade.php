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
                    <tr>
                        <th class="pb-2 text-left">{{__('Choose a Practice to view')}}</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($practices as $practice)
                        <tr class="border-b">
                            <td class="py-2">
                                <a href="{{ route('practices.show', $practice->id) }}" class="text-blue-600 hover:text-blue-800">
                                    {{ \Carbon\Carbon::parse($practice->date)->format('d.m.Y') }} - {{ $practice->topic }}
                                </a>
                            </td>
                            <td class="py-2">
                                <form action="{{ route('practices.destroy', $practice->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-4 py-2 text-white bg-red-500 hover:bg-red-700 rounded-lg" onclick="return confirm('{{__('Are you sure you want to delete this practice?')}}')">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10 9.99998C10.5523 9.99998 11 10.4477 11 11V16C11 16.5523 10.5523 17 10 17C9.44772 17 9 16.5523 9 16V11C9 10.4477 9.44772 9.99998 10 9.99998Z" fill="white"/>
                                            <path d="M14 9.99998C14.5523 9.99998 15 10.4477 15 11V16C15 16.5523 14.5523 17 14 17C13.4477 17 13 16.5523 13 16V11C13 10.4477 13.4477 9.99998 14 9.99998Z" fill="white"/>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M9 0.999977C7.89543 0.999977 7 1.89541 7 2.99998V4.99998H3C2.44772 4.99998 2 5.44769 2 5.99998C2 6.55226 2.44772 6.99998 3 6.99998H4.11765L4.88926 20.1174C4.95145 21.1746 5.82686 22 6.88581 22H17.1142C18.1731 22 19.0486 21.1746 19.1107 20.1174L19.8824 6.99998H21C21.5523 6.99998 22 6.55226 22 5.99998C22 5.44769 21.5523 4.99998 21 4.99998H17V2.99998C17 1.89541 16.1046 0.999977 15 0.999977H9ZM6.12111 6.99998L6.88581 20H17.1142L17.8789 6.99998H6.12111ZM9 2.99998H15V4.99998H9V2.99998Z" fill="white"/>
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>

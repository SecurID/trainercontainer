<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Exercises') }}
            </h2>
            <div>
                <a href="/exercises/create">
                    <button class="px-4 py-2 text-white bg-blue-500 hover:bg-blue-700 rounded">
                        {{ __('Create Exercise') }}
                    </button>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex flex-wrap -mx-1 lg:-mx-4 mb-5" id="myTab" role="tablist">
                    <!-- Tab Items -->
                    <a class="text-blue-600 py-2 px-4 inline-block hover:text-blue-800 active" id="all-tab" data-tab-target="#all" role="tab" aria-controls="all">{{__('All')}}</a>
                    @foreach($categories as $category)
                        <a class="text-blue-600 py-2 px-4 inline-block hover:text-blue-800" id="{{$category->name}}-tab" data-tab-target="#{{$category->name}}" role="tab" aria-controls="{{$category->name}}">{{__($category->name)}}</a>
                    @endforeach
                </div>
                <div id="myTabContent">
                    <!-- Tab Panels -->
                    <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach ($exercises as $exercise)
                                <div class="card rounded overflow-hidden shadow-lg">
                                    <img class="w-full" src="{{$exercise->image}}" alt="{{$exercise->name}}">
                                    <div class="px-6 py-4">
                                        <div class="font-bold text-xl mb-2">{{$exercise->name}}</div>
                                    </div>
                                    <div class="px-6 pt-4 pb-2">
                                        <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">Duration: {{$exercise->duration}} min</span>
                                        <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">Intensity: {{$exercise->intensity}}%</span>
                                    </div>
                                </div>
                                @if ($loop->iteration % 7 == 0)
                                    <!-- Manage row break or new row here if necessary -->
                                @endif
                            @endforeach
                        </div>
                    </div>
                    @foreach($categories as $category)
                        <div class="tab-pane fade" id="{{$category->name}}" role="tabpanel" aria-labelledby="{{$category->name}}-tab">
                            <!-- Category specific content here -->
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

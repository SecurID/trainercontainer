<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <x-back-button></x-back-button>
            <h2 class="text-xl font-semibold text-gray-800 leading-tight">
                {{ __('Update Exercise') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form method="POST" action="{{ route('exercises.update', $exercise->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <x-input type="text" class="w-full" placeholder="{{ __('Name') }}" name="name" value="{{ $exercise->name }}" />
                        <x-input type="text" class="w-full" placeholder="{{ __('Focus') }}" name="focus" value="{{ $exercise->focus }}" />
                    </div>
                    <div class="grid grid-cols-1 mb-4 w-full">
                        <select name="categories[]" class="form-input rounded-md shadow-sm w-full text-gray-500" multiple>
                            <option disabled>{{ __('Choose Categories') }}</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" @if(in_array($category->id, $exercise->categories->pluck('id')->toArray())) selected @endif>
                                    {{ __($category->name) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-4">
                        <x-input type="text" class="w-full" placeholder="{{ __('Material') }}" name="material" value="{{ $exercise->material }}" />
                        <x-input type="text" class="w-full" placeholder="{{ __('Duration') }}" name="duration" value="{{ $exercise->duration }}" />
                        <x-input type="text" class="w-full mr-2" placeholder="{{ __('Intensity') }}" name="intensity" value="{{ $exercise->intensity }}" />
                    </div>
                    <textarea class="form-input rounded-md shadow-sm w-full mb-4" placeholder="{{ __('Procedure') }}" name="procedure">{{ $exercise->procedure }}</textarea>
                    <textarea class="form-input rounded-md shadow-sm w-full mb-4" placeholder="{{ __('Coaching') }}" name="coaching">{{ $exercise->coaching }}</textarea>
                    <div class="flex items-center mb-4">
                        <label class="block text-md font-medium text-gray-500 mr-4 mb-2">
                            {{ __('Drawing') }}
                        </label>
                        <input type="file" class="form-input rounded-md shadow-sm border-[1px] border-gray-500 w-full text-gray-500" name="drawing">
                        @if($exercise->drawing)
                            <span>{{ __('Existing drawing file: ') . $exercise->drawing }}</span>
                        @endif
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white font-bold rounded">
                            {{ __('Update Exercise') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

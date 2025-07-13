<div>
    <div class="flex flex-wrap -mx-1 lg:-mx-4 mb-5" id="myTab" role="tablist">
        <a href="#" wire:click.prevent="filterByCategory('all')"
           class="m-1 py-2 px-4 inline-block rounded-lg text-sm font-medium leading-5 transition duration-150 ease-in-out border hover:bg-blue-100 focus:outline-none focus:shadow-outline {{ $selectedCategoryId == 'all' ? 'bg-blue-500 text-white border-blue-500 hover:bg-blue-600' : 'text-blue-700 bg-white border-gray-300 hover:text-blue-800' }}">
            {{ __('All') }}
        </a>
    @foreach($categories as $category)
            <a href="#" wire:click.prevent="filterByCategory('{{ $category->id }}')"
               class="m-1 py-2 px-4 inline-block rounded-lg text-sm font-medium leading-5 transition duration-150 ease-in-out border hover:bg-blue-100 focus:outline-none focus:shadow-outline {{ $selectedCategoryId == $category->id ? 'bg-blue-500 text-white border-blue-500 hover:bg-blue-600' : 'text-blue-700 bg-white border-gray-300 hover:text-blue-800' }}">
                {{ __($category->name) }}
            </a>
        @endforeach
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-5 gap-4">
        @foreach ($exercises as $exercise)
            <div class="card rounded overflow-hidden shadow-lg relative">
                <a href="{{ route('exercises.show', ['exercise' => $exercise]) }}">
                    @if($exercise->image)
                        <img class="w-full" src="{{ asset('storage/' . $exercise->image) }}" alt="{{ $exercise->name }}">
                    @endif
                    <div class="px-6 py-4">
                        <div class="font-bold text-xl mb-2">{{ $exercise->name }}</div>
                        <p>{{__('Duration')}}: {{ $exercise->duration }} {{ __('minutes') }}</p>
                        <p>{{__('Intensity')}}: {{ $exercise->intensity }}%</p>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>

<div>
    <div class="flex flex-wrap -mx-1 lg:-mx-4 mb-5" id="myTab" role="tablist">
        <a href="#" wire:click.prevent="filterByCategory('all')"
           class="py-2 px-4 inline-block rounded-lg text-sm font-medium leading-5 transition duration-150 ease-in-out border hover:bg-blue-100 focus:outline-none focus:shadow-outline {{ $selectedCategoryId == 'all' ? 'bg-blue-500 text-white border-blue-500 hover:bg-blue-600' : 'text-blue-700 bg-white border-gray-300 hover:text-blue-800' }}">
            {{ __('All') }}
        </a>
    @foreach($categories as $category)
            <a href="#" wire:click.prevent="filterByCategory('{{ $category->id }}')"
               class="py-2 px-4 inline-block rounded-lg text-sm font-medium leading-5 transition duration-150 ease-in-out border hover:bg-blue-100 focus:outline-none focus:shadow-outline {{ $selectedCategoryId == $category->id ? 'bg-blue-500 text-white border-blue-500 hover:bg-blue-600' : 'text-blue-700 bg-white border-gray-300 hover:text-blue-800' }}">
                {{ __($category->name) }}
            </a>
        @endforeach
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach ($exercises as $exercise)
            <div class="card rounded overflow-hidden shadow-lg">
                <img class="w-full" src="{{ $exercise->image }}" alt="{{ $exercise->name }}">
                <div class="px-6 py-4">
                    <div class="font-bold text-xl mb-2">{{ $exercise->name }}</div>
                    <p>Duration: {{ $exercise->duration }} min</p>
                    <p>Intensity: {{ $exercise->intensity }}%</p>
                </div>
            </div>
        @endforeach
    </div>
</div>

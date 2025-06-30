<div
    x-data="{
        open: false,
        selected: @entangle($attributes->wire('model')),
        options: {{ Illuminate\Support\Js::from($options) }},
        toggle(id) {
            if (this.selected.includes(id)) {
                this.selected = this.selected.filter(i => i !== id)
            } else {
                this.selected.push(id)
            }
        }
    }"
    class="relative"
>
    <button type="button" @click="open = !open"
            class="rounded-none w-full border-0 border-b-2 text-gray-500 border-gray-300 focus:border-blue-500 focus:ring-0 text-left flex justify-between items-center py-2 bg-white">
        <span class="ml-3" x-text="selected.length ? options.filter(o => selected.includes(o.id)).map(o => o.name).join(', ') : '{{ $placeholder ?? __('Choose') }}'"></span>
        <svg class="w-4 h-4 ml-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>
    <div x-show="open" @click.away="open = false"
         class="absolute z-10 mt-1 w-full bg-white border border-b-2 border-gray-300 rounded-none shadow">
        <template x-for="option in options" :key="option.id">
            <div @click="toggle(option.id)" class="px-4 py-2 hover:bg-gray-100 cursor-pointer flex items-center">
                <input type="checkbox" class="mr-2" :checked="selected.includes(option.id)" @change="toggle(option.id)">
                <span class="text-gray-500" x-text="option.name"></span>
            </div>
        </template>
    </div>
</div>

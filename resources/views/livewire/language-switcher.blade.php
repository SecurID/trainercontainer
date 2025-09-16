<div class="relative" x-data="{ open: false }">
    <!-- Desktop Version -->
    <div class="hidden sm:block">
        <button @click="open = !open" @click.outside="open = false"
                class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
            <span>{{ $availableLocales[$currentLocale] }}</span>
            <svg class="ml-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>

        <div x-show="open"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="transform opacity-0 scale-95"
             x-transition:enter-end="transform opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-75"
             x-transition:leave-start="transform opacity-100 scale-100"
             x-transition:leave-end="transform opacity-0 scale-95"
             class="absolute right-0 mt-2 w-40 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5"
             style="display: none;">
            <div class="py-1" role="menu" aria-orientation="vertical">
                @foreach($availableLocales as $locale => $language)
                    <button wire:click="switchLanguage('{{ $locale }}')"
                            class="w-full flex text-left px-4 py-2 text-sm {{ $currentLocale === $locale ? 'bg-gray-100 text-gray-900 font-bold' : 'text-gray-700' }} hover:bg-gray-100 hover:text-gray-900"
                            role="menuitem">
                        {{ $language }}
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Mobile Version -->
    <div class="sm:hidden">
        <div class="border-t border-gray-200 pt-4 pb-3">
            <div class="px-4">
                <div class="text-base font-medium text-gray-800">{{ __('Language') }}</div>
                <div class="mt-3 space-y-1">
                    @foreach($availableLocales as $locale => $language)
                        <button wire:click="switchLanguage('{{ $locale }}')"
                                class="block w-full text-left px-3 py-2 rounded-md text-base font-medium {{ $currentLocale === $locale ? 'bg-primary-100 text-primary-900' : 'text-gray-600 hover:text-gray-800 hover:bg-gray-50' }}">
                            {{ $language }}
                            @if($currentLocale === $locale)
                                <span class="ml-2 text-primary-600">✓</span>
                            @endif
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<flux:dropdown position="bottom" align="end">
    <flux:button variant="ghost" icon-trailing="chevron-down" size="sm">
        <span class="max-sm:sr-only">{{ $availableLocales[$currentLocale] }}</span>
    </flux:button>

    <flux:menu>
        <flux:menu.heading>{{ __('Language') }}</flux:menu.heading>
        @foreach($availableLocales as $locale => $language)
            <flux:menu.item
                wire:click="switchLanguage('{{ $locale }}')"
                icon="{{ $currentLocale === $locale ? 'check' : '' }}"
            >
                {{ $language }}
            </flux:menu.item>
        @endforeach
    </flux:menu>
</flux:dropdown>

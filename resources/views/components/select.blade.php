<select {{ $attributes->merge([
    'class' => 'text-text-secondary rounded-none w-full border-0 border-b-2 border-border-default focus:border-primary-500 focus:ring-0',
]) }}>
    {{ $slot }}
</select>


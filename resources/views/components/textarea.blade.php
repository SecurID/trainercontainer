<textarea {{ $attributes->merge([
    'class' => 'rounded-none w-full mb-4 border-0 border-b-2 border-border-default focus:border-primary-500 focus:ring-0',
]) }}>{{ $slot }}</textarea>

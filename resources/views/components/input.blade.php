@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'rounded-none w-full border-0 border-b-2 border-border-default focus:border-primary-500 focus:ring-0']) !!}>

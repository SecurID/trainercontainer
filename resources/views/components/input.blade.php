@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'rounded-none w-full border-0 border-b-2 border-gray-300 focus:border-blue-500 focus:ring-0']) !!}>

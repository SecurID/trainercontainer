<select {{ $attributes->merge([
    'class' => 'text-gray-500 rounded-none w-full border-0 border-b-2 border-gray-300 focus:border-blue-500 focus:ring-0',
]) }}>
    {{ $slot }}
</select>


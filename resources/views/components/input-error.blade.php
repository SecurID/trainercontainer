@props(['for'])

@error($for)
    <p {{ $attributes->merge(['class' => 'text-sm text-error-red']) }}>{{ $message }}</p>
@enderror

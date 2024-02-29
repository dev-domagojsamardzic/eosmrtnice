@props(['value'])

<label {{ $attributes->merge(['class' => 'text-xs font-weight-bold text-dark']) }}>
    {{ $value ?? $slot }}
</label>

@props(['content'])

@php($class = ($attributes['inline']) ? 'text-xs d-inline-block mb-1 ml-1' : 'text-xs d-block mb-1')

<small {{ $attributes->merge(['class' => $class]) }}>
    <i class="fas fa-info-circle mr-0.5"></i>
    {{ $content ?? $slot }}
</small>

@props(['content'])
<small {{ $attributes->merge(['class' => 'text-xs d-block mb-1']) }}>
    <i class="fas fa-info-circle mr-0.5"></i>
    {{ $content ?? $slot }}
</small>

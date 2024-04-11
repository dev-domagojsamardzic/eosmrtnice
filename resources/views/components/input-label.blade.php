@props(['value', 'required_tag' => false])

<label {{ $attributes->merge(['class' => 'text-xs font-weight-bold text-dark']) }}>
    {{ $value ?? $slot }} {{ $required_tag ? __('common.required_tag') : '' }}
</label>

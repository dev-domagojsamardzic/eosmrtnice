@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'list-unstyled text-xs text-danger font-weight-bold']) }}>
        @foreach ((array) $messages as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>
@endif

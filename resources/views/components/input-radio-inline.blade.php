@props(['name' => $name, 'options' => $options, 'selected' => $selected])

@foreach($options as $key => $value)
    @php
        $id = \Illuminate\Support\Arr::join(['radio', $value, $key], '_')
    @endphp
    <div class="custom-control custom-radio custom-control-inline small">
        <input type="radio" name="{{ $name }}" class="custom-control-input " id="{{ $id }}" value="{{ $key }}" {{ $selected === $key ? 'checked' : '' }}>
        <label class="custom-control-label" for="{{ $id }}">{{ $value }}</label>
    </div>
@endforeach

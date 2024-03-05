@props(['name' => $name, 'options' => $options])

@foreach($options as $key => $value)
    @php
        $id = \Illuminate\Support\Arr::join(['radio', $value, $key], '_')
    @endphp
    <div class="custom-control custom-radio custom-control-inline small">
        <input type="radio" name="{{ $name }}" class="custom-control-input " id="{{ $id }}" value="{{ $key }}">
        <label class="custom-control-label" for="{{$id}}">{{ $value }}</label>
    </div>
@endforeach

<div class="px-4 py-3 bg-gray-100">
    <p>
        <span class="font-medium">{{ __('models/ad.months_valid') }}: </span>
        <span>{{ $getRecord()->months_valid . ' ' . __('common.months')}} </span>
    </p>
    <p>
        <span class="font-medium">{{ __('models/ad.valid_from') }}: </span>
        <span>{{ $getRecord()->valid_from?->format('d.m.Y.') }}</span>
    </p>
    <p>
        <span class="font-medium">{{ __('models/ad.valid_until') }}: </span>
        <span>{{ $getRecord()->valid_until?->format('d.m.Y.') }}</span>
    </p>
</div>

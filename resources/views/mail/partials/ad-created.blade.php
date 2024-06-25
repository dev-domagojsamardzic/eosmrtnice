<p>{{ __('mail.greetings') }}</p>
<p>
    {{ __('mail.ad_created.intro', [
        'owner' => $ad->user?->full_name ?? __('mail.unknown_sender'),
        'company' => $ad->company?->title ?? __('mail.unknown_company'),
        'datetime' => $ad->created_at->format('d.m.Y. H:i'),
    ])}}
</p>

<p>{{ __('mail.ad_created.ad_properties') }}</p>
<ul>
    <li><strong>{{ __('models/ad.type') }}: </strong>{{ ucfirst($ad->type->name) }}</li>
    <li><strong>{{ __('models/ad.months_valid') }}: </strong>{{ ucfirst($ad->months_valid) }} {{ __('common.months') }}</li>
    @if($ad->type !== \App\Enums\AdType::STANDARD)
        <li><strong>{{ __('models/company.logo') }}: </strong>{{ $ad->company?->logo ?? __('company.no_logo') }}</li>
    @endif
    @if($ad->type === \App\Enums\AdType::GOLD)
        <li><strong>{{ __('models/ad.banner') }}: </strong>{{ $ad->banner ?? __('ad.no_banner') }}</li>
        <li><strong>{{ __('models/ad.caption') }}: </strong>{{ $ad->caption ?? __('ad.no_caption') }}</li>
    @endif
</ul>
<p>{{ __('mail.ad_created.outro') }}</p>
<p>{{ __('mail.kind_regards') }}</p>
<p>{{ config('app.name') }} {{ __('mail.team') }}</p>

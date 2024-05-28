<p>{{ __('mail.offer_created.greetings') }}</p>

<p>{{ __('mail.offer_created.intro') }}</p>
<p>{{ __('models/ad.ad') . ': ' . $offer->ads?->first()?->title }}</p>
<p>{{ __('models/ad.months_valid') . ': ' . $offer->ads?->first()?->months_valid . ' ' . __('common.months') }}</p>
<p>{{ __('models/offer.valid_from') . ': ' . $offer->valid_from->format('d.m.Y.') }}</p>
<p>{{ __('models/offer.valid_until') . ': ' . $offer->valid_until->format('d.m.Y.') }}</p>

<p>{{ __('mail.offer_created.payment') }}</p>

<p>{{ __('mail.offer_created.contact_info') }}</p>

<p>{{ __('mail.kind_regards') }}</p>
<p>{{ config('app.name') }} {{ __('mail.team') }}</p>

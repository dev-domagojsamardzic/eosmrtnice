<x-mail::message>
# {{ __('mail.greetings') }}

{{ __('mail.ad_created.intro', [
        'owner' => $ad->user?->full_name ?? __('mail.unknown_sender'),
        'company' => $ad->company?->title ?? __('mail.unknown_company'),
        'datetime' => $ad->created_at->format('d.m.Y. H:i'),
    ])
}}

{{ __('mail.ad_created.ad_properties') }}

<x-mail::table>
    <table class="data_table">
        <tbody>
        <tr>
            <td class="text-bold">{{ __('models/ad.type') }}</td>
            <td class="text-right">{{ ucfirst($ad->type->name) }}</td>
        </tr>
        <tr>
            <td class="text-bold">{{ __('models/ad.months_valid') }}</td>
            <td class="text-right">{{ $ad->months_valid . ' ' . __('common.months') }}</td>
        </tr>
        <tr>
            <td class="text-bold">{{ __('models/ad.title') }}</td>
            <td class="text-right">{{ $ad->title }}</td>
        </tr>
        @if($ad->type !== \App\Enums\AdType::STANDARD)
            <tr>
                <td class="text-bold">{{ __('models/company.logo') }}</td>
                <td class="text-right">{{ $ad->company?->logo ? __('common.yes') : __('common.no') }}</td>
            </tr>
        @endif
        @if($ad->type === \App\Enums\AdType::GOLD)
            <tr>
                <td class="text-bold">{{ __('models/ad.banner') }}</td>
                <td class="text-right">{{ $ad->banner ? __('common.yes') : __('common.no') }}</td>
            </tr>
            <tr>
                <td class="text-bold">{{ __('models/ad.caption') }}</td>
                <td class="text-right">{{ $ad->caption ?? __('ad.no_caption') }}</td>
            </tr>
        @endif
        </tbody>
    </table>
</x-mail::table>

{{ __('mail.ad_created.outro') }}

{{ __('mail.kind_regards') }}

<x-mail::signature></x-mail::signature>
</x-mail::message>



{{ config('app.name') }} {{ __('mail.team') }}

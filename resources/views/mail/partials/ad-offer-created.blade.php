<x-mail::message>
# {{ __("mail.$actionKey.greetings") }}

{{ __("mail.$actionKey.intro") }}
<x-mail::table>
    <table class="data_table">
        <tbody>
        <tr>
            <td class="text-bold">{{ __('models/ad.ad') }}</td>
            <td class="text-right">{{ $offerable?->title }}</td>
        </tr>
        <tr>
            <td class="text-bold">{{ __('models/ad.months_valid') }}</td>
            <td class="text-right">{{ $offerable?->months_valid . ' ' . __('common.months') }}</td>
        </tr>
        <tr>
            <td class="text-bold">{{ __('models/offer.valid_from') }}</td>
            <td class="text-right">{{ $offer->valid_from->format('d.m.Y.') }}</td>
        </tr>
        <tr>
            <td class="text-bold">{{ __('models/offer.valid_until') }}</td>
            <td class="text-right">{{ $offer->valid_until->format('d.m.Y.') }}</td>
        </tr>
        </tbody>
    </table>
</x-mail::table>


{{ __("mail.$actionKey.payment") }}

{{ __("mail.$actionKey.contact_info") }}

{{ __('mail.kind_regards') }}
{{ config('app.name') }} {{ __('mail.team') }}
</x-mail::message>


<x-mail::message>
# {{ __("mail.$actionKey.greetings") }}

{{ __("mail.$actionKey.intro", ['offer' => $condolences_offer->number]) }}
<x-mail::table>
    <table class="data_table">
        <tbody>
            <tr>
                <td class="text-bold">{{ __('models/condolence.motive') }}</td>
                <td class="text-right">{{ $condolences_offer->condolence?->motive->value }}</td>
            </tr>
            <tr>
                <td class="text-bold">{{ __('models/condolence.package_addon') }}</td>
                <td class="text-right">
                    @if($condolences_offer->condolence->package_addon)
                        <ul class="list-disc pl-4"></ul>
                        @foreach($condolences_offer->condolence->addons as $addon)
                            <li>{{ $addon }}</li>
                        @endforeach
                    @else
                        <span>{{ __('common.none') }}</span>
                    @endif
                </td>
            </tr>
            <tr>
                <td class="text-bold">{{ __('models/condolence.message') }}</td>
                <td class="text-center">{{ $condolences_offer->condolence->message }}</td>
            </tr>
            <tr>
                <td class="text-bold">{{ __('models/condolence.sender_data') }}</td>
                <td class="text-right">
                    <span>{{ $condolences_offer->condolence?->sender_full_name ?? ''}}</span><br>
                    <span>{{ $condolences_offer->condolence?->sender_email ?? ''}}</span><br>
                    <span>{{ $condolences_offer->condolence?->sender_phone ?? ''}}</span><br>
                    <span>{!! $condolences_offer->condolence?->sender_address !!}</span><br>
                    <span>{!! $condolences_offer->condolence?->sender_additional_info !!}</span>
                </td>
            </tr>
            <tr>
                <td class="text-bold">{{ __('models/condolence.recipient_data') }}</td>
                <td class="text-right">
                    {{ $condolences_offer->condolence?->recipient_full_name }}<br>
                    {{ $condolences_offer->condolence?->recipient_address }}
                </td>
            </tr>
        </tbody>
    </table>
</x-mail::table>


{{ __("mail.$actionKey.payment") }}

{{ __("mail.$actionKey.contact_info") }}

{{ __('mail.kind_regards') }}

<x-mail::signature></x-mail::signature>
</x-mail::message>


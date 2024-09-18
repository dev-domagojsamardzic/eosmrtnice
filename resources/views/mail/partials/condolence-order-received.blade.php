<x-mail::message>
# {{ __("mail.condolence_order_received.greetings") }}

{{ __("mail.condolence_order_received.intro", ['number' => $condolence->number]) }}

{{ __("mail.condolence_order_received.data_intro") }}

{{ __("mail.condolence_order_received.data_intro_contact", ["mail" => config("eosmrtnice.company.email"), "phone" => config("eosmrtnice.company.phone")]) }}

### {{ __("mail.condolence_order_received.order_info") }}

<x-mail::table>
<table class="data_table">
<tbody>
<tr>
<td class="text-bold">{{ __('models/condolence.motive') }}</td>
<td class="text-right">{{ $condolence->motive->value }}</td>
</tr>
<tr>
<td class="text-bold">{{ __('models/condolence.message') }}</td>
<td class="text-center">{!! $condolence->message !!}</td>
</tr>
<tr>
<td class="text-bold">{{ __('models/condolence.package_addon') }}</td>
<td class="text-right">
@foreach($condolence->addons as $addon)
{{ $addon }}<br>
@endforeach
</td>
</tr>
</tbody>
</table>
</x-mail::table>

### {{ __("mail.condolence_order_received.recipient_data") }}

<x-mail::table>
<table class="data_table">
<tbody>
<tr>
<td class="text-bold">{{ __('models/condolence.recipient_full_name') }}</td>
<td class="text-right">{{ $condolence->recipient_full_name }}</td>
</tr>
<tr>
<td class="text-bold">{{ __('models/condolence.recipient_address') }}</td>
<td class="text-right">{!! $condolence->recipient_address !!}</td>
</tr>
</tbody>
</table>
</x-mail::table>

### {{ __("mail.condolence_order_received.sender_data") }}

<x-mail::table>
<table class="data_table">
<tbody>
<tr>
<td class="text-bold">{{ __('models/condolence.sender_full_name') }}</td>
<td class="text-right">{{ $condolence->sender_full_name }}</td>
</tr>
<tr>
<td class="text-bold">{{ __('models/condolence.sender_email') }}</td>
<td class="text-right">{{ $condolence->sender_email }}</td>
</tr>
<tr>
<td class="text-bold">{{ __('models/condolence.sender_phone') }}</td>
<td class="text-right">{{ $condolence->sender_phone }}</td>
</tr>
<tr>
<td class="text-bold">{{ __('models/condolence.sender_address') }}</td>
<td class="text-right">{!! $condolence->sender_address !!}</td>
</tr>
<tr>
<td class="text-bold">{{ __('models/condolence.sender_additional_info') }}</td>
<td class="text-right">{!! $condolence->sender_additional_info !!}</td>
</tr>
</tbody>
</table>
</x-mail::table>

{{ __('mail.kind_regards') }}

<x-mail::signature></x-mail::signature>

</x-mail::message>

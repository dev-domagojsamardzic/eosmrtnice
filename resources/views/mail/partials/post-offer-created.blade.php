<x-mail::message>
# {{ __("mail.$actionKey.greetings") }}

{{ __("mail.$actionKey.intro", ['offer' => $posts_offer->number]) }}
<x-mail::table>
<table class="data_table">
    <tbody>
        <tr>
            <td class="text-bold">{{ __('models/post.post') }}</td>
            <td class="text-right">{{ $posts_offer->post?->type->translate() }}</td>
        </tr>
        <tr>
            <td class="text-bold">{{ __('models/post.size') }}</td>
            <td class="text-right">{{ __('common.to').' '.$posts_offer->post?->size->value.' '.__('common.words') }}</td>
        </tr>
        <tr>
            <td class="text-bold">{{ __('models/deceased.deceased') }}</td>
            <td class="text-right">{{ $posts_offer->post?->deceased_full_name_lg }}</td>
        </tr>
        <tr>
            <td class="text-bold">{{ __('models/post.is_framed') }}</td>
            <td class="text-right">{{ $posts_offer->post?->is_framed ? __('common.yes') : __('common.no') }}</td>
        </tr>
        <tr>
            <td class="text-bold">{{ __('models/post.symbol') }}</td>
            <td class="text-right">{{ $posts_offer->post?->symbol->translate() }}</td>
        </tr>
        <tr>
            <td class="text-bold">{{ __('models/post.starts_at') }}</td>
            <td class="text-right">{{ $posts_offer->post?->starts_at->format('d.m.Y.') }}</td>
        </tr>
    </tbody>
</table>
</x-mail::table>

{{ __("mail.$actionKey.payment") }}

{{ __("mail.$actionKey.contact_info") }}

{{ __('mail.kind_regards') }}

<x-mail::signature></x-mail::signature>
</x-mail::message>

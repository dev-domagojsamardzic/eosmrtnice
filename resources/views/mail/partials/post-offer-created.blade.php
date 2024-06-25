<x-mail::message>
# {{ __("mail.$actionKey.greetings") }}

{{ __("mail.$actionKey.intro") }}
<x-mail::table>
<table class="data_table">
    <tbody>
        <tr>
            <td class="text-bold">{{ __('models/post.post') }}</td>
            <td class="text-right">{{ $offerable->type->translate() }}</td>
        </tr>
        <tr>
            <td class="text-bold">{{ __('models/post.size') }}</td>
            <td class="text-right">{{ __('common.to').' '.$offerable->size->value.' '.__('common.words') }}</td>
        </tr>
        <tr>
            <td class="text-bold">{{ __('models/deceased.deceased') }}</td>
            <td class="text-right">{{ $offerable->deceased->full_name }}</td>
        </tr>
        <tr>
            <td class="text-bold">{{ __('models/post.is_framed') }}</td>
            <td class="text-right">{{ $offerable->is_framed ? __('common.yes') : __('common.no') }}</td>
        </tr>
        <tr>
            <td class="text-bold">{{ __('models/post.symbol') }}</td>
            <td class="text-right">{{ $offerable->symbol->translate() }}</td>
        </tr>
        <tr>
            <td class="text-bold">{{ __('models/post.starts_at') }}</td>
            <td class="text-right">{{ $offerable->starts_at->format('d.m.Y.') }}</td>
        </tr>
    </tbody>
</table>
</x-mail::table>

{{ __("mail.$actionKey.payment") }}

{{ __("mail.$actionKey.contact_info") }}

{{ __('mail.kind_regards') }}

<x-mail::signature></x-mail::signature>
</x-mail::message>

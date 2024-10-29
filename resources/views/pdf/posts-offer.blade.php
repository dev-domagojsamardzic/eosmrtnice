@extends('layouts.pdf')
@section('title')
    {{ __('models/offer.offer') }} {{ $offer->number }}
@endsection

@section('body')
    @include('pdf.partials.header', ['reference_number' => str_replace('/web1/', '-', $offer->number)])

    <table class="w-100 mt-16">
        <thead>
        <tr class="h-72">
            <th class="text-align-left font-size-md">{{ __('models/offer.offer_number') . ' ' . $offer->number}}</th>
        </tr>
        </thead>
        <tbody>
        <tr class="mt-16">
            <td class="text-align-left">
                <table>
                    <tr><td><strong>{{ __('models/offer.buyer') }}:</strong></td></tr>
                    <tr><td>{{ $offer->user->full_name }}</td></tr>
                    <tr><td>{{ $offer->user->email }}</td></tr>
                    <tr><td>{{ $offer->user->oib }}</td></tr>
                    <tr><td>{{ config('app.country') }}</td></tr>
                </table>
            </td>
            <td class="text-align-right">
                <table class="w-100">
                    <tr>
                        <td class="text-align-left">{{ __('models/offer.issue_date') }}</td>
                        <td class="text-align-right">{{ $offer->created_at->format('d.m.Y.') }}</td>
                    </tr>
                    <tr>
                        <td class="text-align-left">{{ __('models/offer.issue_town') }}</td>
                        <td class="text-align-right">{{ company_data('town') }}</td>
                    </tr>
                    <tr>
                        <td class="text-align-left">{{ __('models/offer.issue_time') }}</td>
                        <td class="text-align-right">{{ $offer->created_at->format('H:i') }}</td>
                    </tr>
                    <tr>
                        <td class="text-align-left">{{ __('models/offer.valid_until') }}</td>
                        <td class="text-align-right">{{ $offer->valid_until->format('d.m.Y.') }}</td>
                    </tr>
                </table>
            </td>
        </tr>
        </tbody>
    </table>

    <table class="items-table w-100 mt-32">
        <thead>
        <tr>
            <th class="text-align-left">{{ __('models/post.post') }}</th>
            <th class="text-align-right">{{ __('models/offer.quantity') }}</th>
            <th class="text-align-left">{{ __('models/offer.price') }}</th>
            <th class="text-align-right">{{ __('models/offer.total') }}</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="text-align-left">
                <b>{{ $offer->post?->type->translate() }}</b><br>
                {{ __('common.to') . ' ' . $offer->post?->size . ' ' . __('common.words') }}<br>
                {{ __('models/post.starts_at') . ': ' . $offer->post?->starts_at->format('d.m.Y.') }}<br>
                {{ __('models/post.deceased_full_name') . ': ' . $offer->post?->deceased_full_name_lg }}<br>
                {{ __('models/post.deceased_image') . ': ' . ($offer->post?->image ? __('common.yes') : __('common.no')) }}<br>
                {{ __('models/post.is_framed') . ': ' . ($offer->post?->is_framed ? __('common.yes') : __('common.no')) }}<br>
                {{ __('models/post.symbol') . ': ' . $offer->post?->symbol->translate() }}<br>
            </td>
            <td class="text-align-right">{{ $offer->quantity }}</td>
            <td class="text-align-right">{{ currency($offer->price) }}</td>
            <td class="text-align-right">{{ currency($offer->total) }}</td>
        </tr>

        <tr>
            <td class="text-align-left" colspan="3">
                <strong>{{ __('models/offer.pdv_basis') . ' ' . percentage(config('app.tax_percentage'))}}</strong>
            </td>
            <td class="text-align-right">
                <strong>{{ currency($offer->net_total) }}</strong>
            </td>
        </tr>

        <tr>
            <td class="text-align-left" colspan="3">
                <strong>{{ __('models/offer.pdv_amount') }}</strong>
            </td>
            <td class="text-align-right">
                <strong>{{ currency($offer->taxes) }}</strong>
            </td>
        </tr>

        <tr class="background-lightgrey">
            <td class="text-align-left" colspan="3"><strong>{{ __('models/offer.total_to_pay') }}</strong></td>
            <td class="text-align-right"><strong>{{ currency($offer->total) }}</strong></td>
        </tr>
        </tbody>
    </table>

    @include('pdf.partials.remark')
    @include('pdf.partials.footer')
@endsection

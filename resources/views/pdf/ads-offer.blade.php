@extends('layouts.pdf')
@section('title')
    {{ __('models/offer.offer') }} {{ $offer->number }}
@endsection

@section('body')
    @include('pdf.partials.header')

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
                    <tr><td>{{ $offer->company->title }}</td></tr>
                    <tr><td>{{ $offer->company->address }}</td></tr>
                    <tr><td>{{ $offer->company->zipcode . ' ' . $offer->company->city->title }}</td></tr>
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
            <th class="text-align-left">{{ __('models/ad.ad') }}</th>
            <th class="text-align-right">{{ __('models/offer.quantity') }}</th>
            <th class="text-align-left">{{ __('models/offer.price') }}</th>
            <th class="text-align-right">{{ __('models/offer.total') }}</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="text-align-left">
                {{ $offer->ad?->title ?? $offer->ad->fallbackTitle }}<br>
                {{ __('models/ad.type') . ': ' . $offer->ad?->type->translate() }}<br>
                {{ __('models/ad.months_valid') .': '.$offer->ad?->months_valid .' '. __('common.months') }}
            </td>
            <td class="text-align-right">{{ $offer->quantity }}</td>
            <td class="text-align-right">{{ currency($offer->price) }}</td>
            <td class="text-align-right">{{ currency($offer->total) }}</td>
        </tr>

        <tr>
            <td class="text-align-left" colspan="3"><strong>{{ __('models/offer.pdv_basis') . ' ' . percentage(config('app.tax_percentage')) }}</strong></td>
            <td class="text-align-right"><strong>{{ currency($offer->net_total) }}</strong></td>
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

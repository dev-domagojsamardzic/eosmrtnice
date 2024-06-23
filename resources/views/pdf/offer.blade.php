@extends('layouts.pdf')
@section('title')
    {{ __('models/offer.offer') }} {{ $offer->number }}
@endsection

@section('body')
    <table>
        <tbody>
        <tr><td><strong>{{ company_data('title') }}</strong></td></tr>
        <tr><td>{{ company_data('address') }}</td></tr>
        <tr><td>{{ company_data('zipcode') . ', ' . company_data('town') }}</td></tr>
        <tr><td>{{ company_data('country') }}</td></tr>
        <tr><td>{{ __('models/company.oib') }}: {{ company_data('oib') }}</td></tr>
        </tbody>
    </table>

    <table class="w-100 mt-16">
        <thead>
        <tr class="h-72">
            <th class="text-align-left font-size-md">{{ __('models/offer.offer') . ' #' . $offer->id}}</th>
            <th class="text-align-right font-size-md">{{ $offer->number }}</th>
        </tr>
        </thead>
        <tbody>
        <tr class="mt-16">
            <td class="text-align-left">
                @if(!is_null($offer->company))
                    <table>
                        <tr><td><strong>{{ __('models/offer.buyer') }}:</strong></td></tr>
                        <tr><td>{{ $offer->company->title }}</td></tr>
                        <tr><td>{{ $offer->company->address }}</td></tr>
                        <tr><td>{{ $offer->company->zipcode . ' ' . $offer->company->city->title }}</td></tr>
                        <tr><td>{{ config('app.country') }}</td></tr>
                    </table>
                @elseif(!is_null($offer->user))
                    <table>
                        <tr><td><strong>{{ __('models/offer.buyer') }}:</strong></td></tr>
                        <tr><td>{{ $offer->user->full_name }}</td></tr>
                        <tr><td>{{ $offer->user->email }}</td></tr>
                        <tr><td>{{ config('app.country') }}</td></tr>
                    </table>
                @else

                @endif
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
            <th class="text-align-left">{{ __('models/offer.item') }}</th>
            <th class="text-align-right">{{ __('models/offer.quantity') }}</th>
            <th class="text-align-left">{{ __('models/offer.price') }}</th>
            <th class="text-align-right">{{ __('models/offer.total') }}</th>
        </tr>
        </thead>
        <tbody>
        @if($offer->ads)
            @foreach($offer->ads as $item)
                <tr>
                    <td class="text-align-left">{{ $item->title ?? $item->fallbackTitle }}</td>
                    <td class="text-align-right">{{ $item->pivot?->quantity }}</td>
                    <td class="text-align-right">{{ $item->pivot?->price . config('app.currency_symbol') }}</td>
                    <td class="text-align-right">
                        {{ number_format((int)$item->pivot?->quantity * (float)$item->pivot?->price, 2) . config('app.currency_symbol') }}
                    </td>
                </tr>
            @endforeach
        @endif
        @if($offer->posts)
            @foreach($offer->posts as $item)
                <tr>
                    <td class="text-align-left">
                        {{ "{$item->type->translate()}: {$item->deceased_full_name_lg}" }} <br>
                        {{ __('models/post.size').': '.ucfirst($item->size->name).' ('.__('common.to').' '.$item->size->value.' '.__('common.words').')' }} <br>
                        {{ __('models/post.is_framed') }}: {{ $item->is_framed ? __('common.yes') : __('common.no') }}
                    </td>
                    <td class="text-align-right">{{ $item->pivot?->quantity }}</td>
                    <td class="text-align-right">{{ $item->pivot?->price . config('app.currency_symbol') }}</td>
                    <td class="text-align-right">
                        {{ number_format((int)$item->pivot?->quantity * (float)$item->pivot?->price, 2) . config('app.currency_symbol') }}
                    </td>
                </tr>
            @endforeach
        @endif


        <tr>
            <td class="text-align-left" colspan="3"><strong>{{ __('models/offer.pdv') . ' ' . config('app.tax_percentage') . '%'}}</strong></td>
            <td class="text-align-right"><strong>{{ currency($offer->taxes) }}</strong></td>
        </tr>

        <tr class="background-lightgrey">
            <td class="text-align-left" colspan="3"><strong>{{ __('models/offer.total') }}</strong></td>
            <td class="text-align-right"><strong>{{ currency($offer->total) }}</strong></td>
        </tr>
        </tbody>
    </table>
@endsection

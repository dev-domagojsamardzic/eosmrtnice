@inject('carbon', 'Illuminate\Support\Carbon')
<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-gray-800 mb-4 dark:text-gray-200">
            {{ __('models/offer.offer') }} - {{ __("common.{$action_name}") }}
        </h1>
    </x-slot>

    <div>
        <div class="form-group row">
            <div class="col-lg-12">
                <x-input-label for="number" :value="__('models/offer.number')"></x-input-label>
                <h4 class="font-weight-bold">{{ $offer->number }}</h4>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-lg-3 col-md-4 col-sm-12">
                <x-input-label for="valid_from" :value="__('models/offer.valid_from')"></x-input-label>
                <p>{{ $offer->valid_from->format('d.m.Y.') }}</p>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-12">
                <x-input-label for="valid_until" :value="__('models/offer.valid_until')"></x-input-label>
                <p>{{ $offer->valid_until->format('d.m.Y.') }}</p>
            </div>
        </div>

        <table style="color: #131313" class="w-100 table table-bordered mt-5">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Vrsta</th>
                    <th scope="col">Naziv</th>
                    <th scope="col">Kompanija</th>
                    <th scope="col">Količina</th>
                    <th scope="col">Cijena</th>
                </tr>
            </thead>
            <tbody>
                @foreach($offer->offerables as $offerable)
                    <tr>
                        <td>Oglas</td>
                        <td>{{ $offerable->offerable->title }}</td>
                        <td>{{ $offerable->offerable?->company?->title }}</td>
                        <td>{{ $offerable->quantity }}</td>
                        <td>{{ $offerable->price }}</td>
                    </tr>
                @endforeach
                <tr class="table-active">
                    <td colspan="4">{{ __('models/offer.net_total') }}</td>
                    <td>{{ currency($offer->net_total ?? 0) }}</td>
                </tr>
                <tr class="thead-light">
                    <td colspan="4">{{ __('models/offer.taxes') }} {{ '(' . config('app.tax_percentage') . '%)' }}</td>
                    <td>{{ currency($offer->taxes ?? 0) }}</td>
                </tr>
                <tr class="ta-dark">
                    <td colspan="4"><strong>{{ __('models/offer.total') }}</strong></td>
                    <td><strong>{{ currency($offer->total ?? 0) }}</strong></td>
                </tr>
            </tbody>
        </table>

        <div class="form-group row mt-5">
            <div class="col-12">
                <a class="btn btn-primary" href="{{ route('partner.offers.download', ['offer' => $offer]) }}">
                    {{ __('models/offer.download_pdf') }}
                </a>
                <a class="btn btn-link btn-user ml-3" href="{{ $back }}">
                    {{ __('common.back') }}
                </a>
            </div>
        </div>
    </div>
</x-app-layout>

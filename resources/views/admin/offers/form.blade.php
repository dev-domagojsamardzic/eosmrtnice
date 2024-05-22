<x-app-layout>
    <x-slot name="header">
        <h2 class="font-weight-bolder mb-4">
            {{ __('models/offer.offer') }} - {{ __("common.{$action_name}") }}
        </h2>
        <h4 class="font-weight-bold">{{ __('models/ad.ad') . ' ' . $ad->type->name . ' - ' . $ad->company?->title }}</h4>
    </x-slot>

    <div>
        <form method="POST" action="{{ $action }}">
            @csrf
            @if($offer->exists)
                {{ method_field('PUT') }}
            @endif

            <input type="hidden" name="company_id" value="{{ $ad->company->id }}">
            <input type="hidden" name="offerable_type" value="{{ get_class($ad) }}">
            <input type="hidden" name="offerable_id" value="{{ $ad->id }}">

            <div class="form-group row">
                <div class="col-lg-3 col-md-4 col-sm-12">
                    <x-input-label for="valid_from" :value="__('models/offer.valid_from')"></x-input-label>
                    <div class="input-group date">
                        <input name="valid_from"
                               id="valid_from"
                               type="text"
                               class="form-control"
                               value="{{ old('valid_from', $offer->valid_from) ? \Illuminate\Support\Carbon::parse(old('valid_from', $offer->valid_from))->format('d.m.Y.') : now()->format('d.m.Y.') }}">
                        <div class="datepicker-input-group-addon">
                            <span class="fas fa-calendar-alt"></span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-12">
                    <x-input-label for="valid_until" :value="__('models/offer.valid_until')"></x-input-label>
                    <div class="input-group date">
                        <input id="valid_until" type="text" class="form-control" value="{{ old('valid_until', $offer->valid_until) ? \Illuminate\Support\Carbon::parse(old('valid_until', $offer->valid_until))->format('d.m.Y.') : now()->addMonth()->format('d.m.Y.') }}">
                        <div class="datepicker-input-group-addon">
                            <span class="fas fa-calendar-alt"></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <x-input-label for="net_total" :value="__('models/offer.net_total')"></x-input-label>
                    <div class="input-group input-group-joined">
                        <input class="form-control"
                               name="net_total"
                               id="net_total"
                               type="number"
                               min="0"
                               step=".01"
                               value="{{ old('net_total', $offer->net_total) ?? 0.00 }}" required>
                        <span class="input-group-text">{{ config('app.currency_symbol') }}</span>
                    </div>
                    <x-input-error :messages="$errors->get('net_total')" class="mt-2" />
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <x-input-label for="taxes" :value="__('models/offer.taxes')"></x-input-label>
                    <div class="input-group input-group-joined">
                        <input class="form-control" type="text" id="taxes" name="taxes" value="{{ old('taxes', $offer->taxes) ?? 0.00 }}" readonly>
                        <span class="input-group-text">{{ config('app.currency_symbol') }}</span>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-12">
                    <x-input-label for="total" :value="__('models/offer.total')"></x-input-label>
                    <div class="input-group input-group-joined">
                        <input class="form-control font-weight-bold" type="text" name="total" id="total" value="{{ old('total', $offer->total) ?? 0.00 }}" readonly>
                        <span class="input-group-text"><strong>{{ config('app.currency_symbol') }}</strong></span>
                    </div>
                </div>
            </div>

        </form>
        @push('scripts')
            <script type="module">
                $('#valid_from,#valid_until').datepicker({
                    dateFormat: "dd.mm.yy.",
                    minDate: new Date()
                });

                document.getElementById('net_total').addEventListener('input', function() {
                    const net_total = document.querySelector('#net_total');
                    const taxes = document.querySelector('#taxes');
                    const total = document.querySelector('#total');
                    const tax_percentage = parseFloat('{{ config('app.tax_percentage') }}');

                    let net_total_value = isNaN(parseFloat(net_total.value)) ? 0.00 : parseFloat(net_total.value);

                    taxes.value = (net_total_value * (tax_percentage / 100)).toFixed(2)
                    total.value = (net_total_value + (net_total_value * (tax_percentage / 100))).toFixed(2);
                });

            </script>
        @endpush
    </div>
</x-app-layout>

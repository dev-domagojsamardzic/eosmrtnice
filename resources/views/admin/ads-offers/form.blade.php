<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-gray-800 mb-4 dark:text-gray-200">
            {{ __('models/offer.offer') }} - {{ __("common.{$action_name}") }}
        </h1>
    </x-slot>

    <div>
        <form method="POST" action="{{ $action }}">
            @csrf
            @if($offer->exists)
                {{ method_field('PUT') }}
            @endif

            <input type="hidden" name="company_id" value="{{ $ad->company->id }}">
            <input type="hidden" name="ad_id" value="{{ $ad->id }}">

            @if($offer->exists)
                <div class="form-group row">
                    <div class="col-lg-12">
                        <x-input-label for="number" :value="__('models/offer.number')"></x-input-label>
                        <h4>{{ $offer->number }}</h4>
                    </div>
                </div>
            @endif

            <div class="form-group row">
                <div class="col-lg-3 col-md-4 col-sm-12">
                    <x-input-label for="valid_from" :value="__('models/offer.valid_from')"></x-input-label>
                    <div class="input-group input-group-joined date">
                        <input name="valid_from"
                               id="valid_from"
                               type="text"
                               class="form-control"
                               value="{{ old('valid_from', $offer->valid_from) ? \Illuminate\Support\Carbon::parse(old('valid_from', $offer->valid_from))->format('d.m.Y.') : now()->format('d.m.Y.') }}">
                        <span class="input-group-text">
                            <i class="fas fa-calendar-alt"></i>
                        </span>
                    </div>
                    <x-input-error :messages="$errors->get('valid_from')" class="mt-2"/>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-12">
                    <x-input-label for="valid_until" :value="__('models/offer.valid_until')"></x-input-label>
                    <div class="input-group input-group-joined date">
                        <input name="valid_until" id="valid_until" type="text" class="form-control"
                               value="{{ old('valid_until', $offer->valid_until) ? \Illuminate\Support\Carbon::parse(old('valid_until', $offer->valid_until))->format('d.m.Y.') : now()->addMonth()->format('d.m.Y.') }}">
                        <span class="input-group-text">
                            <i class="fas fa-calendar-alt"></i>
                        </span>
                    </div>
                    <x-input-error :messages="$errors->get('valid_until')" class="mt-2"/>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 mt-4">
                    <h5>{{ __('models/offer.offer_items') }}</h5>
                    <hr class="sidebar-divider">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-sm-12 d-flex align-items-start justify-content-end flex-column">
                    <span class="font-weight-bold">{{ __('models/ad.ad') }}: {{ $ad->type->translate() }}</span>
                    <span>{{ $ad->months_valid }} {{ __('common.months') }}</span>
                    <span>{{ $ad->company->title }}</span>
                    <span>{{ __('models/company.oib') }}: {{ $ad->company->oib ?? __('common.unknown') }}</span>
                </div>

                <div class="col-lg-2 col-sm-6">
                    <x-input-label for="quantity" :value="__('models/offer.quantity')"></x-input-label>
                    <div class="input-group input-group-joined">
                        <input class="form-control"
                               name="quantity"
                               id="quantity"
                               type="number"
                               min="1"
                               step="1"
                               value="{{ old('quantity', $offer->offerables?->first()) ?? "1" }}"
                               required>
                    </div>
                    <x-input-error :messages="$errors->get('quantity')" class="mt-2"/>
                </div>

                <div class="col-lg-2 col-sm-6">
                    <x-input-label for="price" :value="__('models/offer.price')"></x-input-label>
                    <div class="input-group input-group-joined">
                        <input class="form-control"
                               name="price"
                               id="price"
                               type="number"
                               min="0.00"
                               step=".01"
                               value="{{ old('price', $offer->offerables?->first()?->price)  ?? "0.00" }}"
                               required>
                        <span class="input-group-text">{{ config('app.currency_symbol') }}</span>
                    </div>
                    <x-input-error :messages="$errors->get('price')" class="mt-2"/>
                </div>
            </div>

            <div class="row d-flex align-items-end justify-content-center flex-column mt-5">
                <div class="col-sm-12">
                    <label class="text-xs font-weight-bold text-dark">{{ __('models/offer.net_total') }}:&emsp;</label>
                    <span id="net_total" class="font-weight-bold">{{ $offer->net_total ?? "0.00" }}</span> {{ config('app.currency_symbol') }}
                </div>
                <div class="col-sm-12">
                    <label class="text-xs font-weight-bold text-dark">{{ __('models/offer.taxes') }} {{ '(' . config('app.tax_percentage') . '%)' }}:&emsp;</label>
                    <span id="taxes" class="font-weight-bold">{{ $offer->taxes ?? "0.00" }}</span> {{ config('app.currency_symbol') }}
                </div>
                <div class="col-sm-12">
                    <label class="text-xs font-weight-bold text-dark">{{ __('models/offer.total') }}:&emsp;</label>
                    <span id="total" class="font-weight-bold">{{ $offer->total ?? "0.00" }}</span> {{ config('app.currency_symbol') }}
                </div>
            </div>

            <div class="form-group row mt-5">
                <div class="col-12">
                    <button name="submit" type="submit" value="save_and_send" class="btn btn-primary btn-user">
                        {{ __('common.save_and_send_offer') }}
                    </button>
                    <button name="submit" type="submit" value="save" class="btn btn-primary btn-user">
                        {{ __('common.save') }}
                    </button>
                    <a class="btn btn-link btn-user ml-5" href="{{ $quit }}">
                        {{ __('common.quit') }}
                    </a>
                </div>
            </div>
        </form>
        @push('scripts')
            <script type="module">
                $('#valid_from,#valid_until').datepicker({
                    dateFormat: "dd.mm.yy.",
                    minDate: new Date(),
                    language: "hr",
                });


                function calculateTotal() {
                    const quantityHtml = document.querySelector('#quantity');
                    const priceHtml = document.querySelector('#price');
                    const taxesHtml = document.querySelector('#taxes');
                    const netTotalHtml = document.querySelector('#net_total');
                    const totalHtml = document.querySelector('#total');

                    let quantity = isNaN(parseInt(quantityHtml.value)) ? 0 : parseInt(quantityHtml.value);
                    let price = isNaN(parseFloat(priceHtml.value)) ? 0.00 : parseFloat(priceHtml.value);

                    let total = quantity * price;
                    let taxes = total * (parseInt('{{ config('app.tax_percentage') }}') / 100);
                    let net_total = total - taxes;


                    netTotalHtml.textContent = net_total.toFixed(2);
                    taxesHtml.textContent = taxes.toFixed(2);
                    totalHtml.textContent = total.toFixed(2);
                }

                document.getElementById('quantity').addEventListener('input', calculateTotal)
                document.getElementById('price').addEventListener('input', calculateTotal)
            </script>
        @endpush
    </div>
</x-app-layout>

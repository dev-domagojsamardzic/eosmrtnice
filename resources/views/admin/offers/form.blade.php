@inject('carbon', 'Illuminate\Support\Carbon')
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

            @if($offer->exists)
                <div class="form-group row">
                    <div class="col-lg-12">
                        <x-input-label for="number" :value="__('models/offer.number')"></x-input-label>
                        <h4 class="font-weight-bold">{{ $offer->number }}</h4>
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
                               value="{{ $carbon::parse(old('valid_from', $offer->valid_from))->format('d.m.Y.') }}">
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
                               value="{{ $carbon::parse(old('valid_from', $offer->valid_until))->format('d.m.Y.') }}">
                        <span class="input-group-text">
                            <i class="fas fa-calendar-alt"></i>
                        </span>
                    </div>
                    <x-input-error :messages="$errors->get('valid_until')" class="mt-2"/>
                </div>
            </div>

            <table style="color: #131313" class="w-100 table table-bordered mt-5">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">{{ __('models/offer.item_type') }}</th>
                        <th scope="col">{{ __('models/offer.item') }}</th>
                        <th scope="col">{{ __('models/offer.recipient') }}</th>
                        <th scope="col">{{ __('models/offer.quantity') }}</th>
                        <th scope="col">{{ __('models/offer.price') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($offer->offerables as $offerable)
                        <tr>
                            <td>{{ __('models/offer.offerables.' . class_basename($offerable->offerable)) }}</td>
                            @if($offerable->offerable instanceof App\Models\Ad)

                                <td>
                                    {{ $offerable->offerable->title }}
                                </td>

                                <td>
                                    {{ $offerable->offerable->company->title }} <br>
                                    {{ $offerable->offerable->company->oib }}
                                </td>
                            @endif
                            @if($offerable->offerable instanceof App\Models\Post)
                                <td class="text-align-left">
                                    {{ "{$offerable->offerable->type->translate()}: {$offerable->offerable->deceased_full_name_lg}" }} <br>
                                    {{ __('models/post.size').': '.ucfirst($offerable->offerable->size->name).' ('.__('common.to').' '.$offerable->offerable->size->value.' '.__('common.words').')' }} <br>
                                    {{ __('models/post.is_framed') }}: {{ $offerable->offerable->is_framed ? __('common.yes') : __('common.no') }}
                                </td>

                                <td>
                                    {{ $offerable->offerable->user->full_name }} <br>
                                    {{ $offerable->offerable->user->email }}
                                </td>
                            @endif

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
                    <button name="submit" type="submit" value="save_and_resend" class="btn btn-primary btn-user">
                        {{ __('common.save_and_resend_offer') }}
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
                });
            </script>
        @endpush
    </div>
</x-app-layout>

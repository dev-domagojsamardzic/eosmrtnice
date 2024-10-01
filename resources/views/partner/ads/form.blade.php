<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-gray-800 mb-4 dark:text-gray-200">
            {{ __('models/ad.ads') }} - {{ __("common.{$action_name}") }} ({{ $company->title }})
        </h2>
        @if($ad->exists)
            <h3 class="font-weight-bold mb-4">{{ __('models/ad.type') . ': ' . $ad->type->name }}</h3>
        @endif
    </x-slot>

    <div>
        <form method="POST" action="{{ $action }}">
            @csrf
            @if($ad->exists)
                {{ method_field('PUT') }}
            @endif

            <input type="hidden" name="company_id" value="{{ $company->id }}">

            {{-- Prevent user from editing ad_type --}}
            @can('set-ad-type', [$ad])
                <div class="form-group row">
                    <div class="col-12 mb-3">
                        <x-input-label class="d-block" :value="__('models/ad.type')"></x-input-label>
                        <div class="btn-group btn-group-lg btn-group-toggle w-100" data-toggle="buttons">
                            <label class="btn rounded-0 btn-secondary {{ (int)old('type', $ad->type->value) === (int)\App\Enums\AdType::STANDARD->value ? 'active' : '' }}">
                                <i class="fas fa-check-circle"></i>
                                <br>
                                <input role="tab" type="radio" name="type" value="{{ \App\Enums\AdType::STANDARD }}" {{ (int)old('type', $ad->type->value) === (int)\App\Enums\AdType::STANDARD->value ? 'checked' : '' }} data-target="{{ strtolower(\App\Enums\AdType::STANDARD->name) }}">
                                {{ \App\Enums\AdType::STANDARD->translate() }}
                            </label>
                            <label class="btn rounded-0 btn-secondary {{ (int)old('type', $ad->type->value) === (int)\App\Enums\AdType::PREMIUM->value ? 'active' : '' }}">
                                <i class="fas fa-medal"></i>
                                <br>
                                <input type="radio" name="type" value="{{ \App\Enums\AdType::PREMIUM }}" {{ (int)old('type', $ad->type->value) === (int)\App\Enums\AdType::PREMIUM->value ? 'checked' : '' }} data-target="{{ strtolower(\App\Enums\AdType::PREMIUM->name) }}">
                                {{ \App\Enums\AdType::PREMIUM->translate() }}
                            </label>
                            <label class="btn rounded-0 btn-secondary {{ (int)old('type', $ad->type->value) === (int)\App\Enums\AdType::GOLD->value ? 'active' : '' }}">
                                <i class="fas fa-gem"></i>
                                <br>
                                <input type="radio" name="type" value="{{ \App\Enums\AdType::GOLD }}" {{ (int)old('type', $ad->type->value) === (int)\App\Enums\AdType::GOLD->value ? 'checked' : '' }} data-target="{{ strtolower(\App\Enums\AdType::GOLD->name) }}">
                                {{ \App\Enums\AdType::GOLD->translate() }}
                            </label>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane fade py-3 {{ (int)old('type', $ad->type->value) === (int)\App\Enums\AdType::STANDARD->value ? 'show active' : '' }}" id="{{ strtolower(\App\Enums\AdType::STANDARD->name) }}" role="tabpanel">
                                <h4 class="text-md font-weight-bold mt-2 mb-4">{{ __('models/ad.info.standard.title') }}</h4>
                                <h6>{{ __('models/ad.prices') }}</h6>
                                <ol>
                                    <li>{{ __('common.monthly') }}: <b>{{ config('eosmrtnice.products.ad_types.standard.price_monthly') . config('app.currency_symbol') }}</b></li>
                                    <li>{{ __('common.annual') }}: <b>{{ config('eosmrtnice.products.ad_types.standard.price_annual') . config('app.currency_symbol') }}</b></li>
                                </ol>
                                {!! __('models/ad.info.standard.text') !!}
                            </div>
                            <div class="tab-pane fade py-3 {{ (int)old('type', $ad->type->value) === (int)\App\Enums\AdType::PREMIUM->value ? 'show active' : '' }}" id="{{ strtolower(\App\Enums\AdType::PREMIUM->name) }}" role="tabpanel">
                                <h4 class="text-md font-weight-bold mt-2 mb-4">{{ __('models/ad.info.premium.title') }}</h4>
                                <h6>{{ __('models/ad.prices') }}</h6>
                                <ol>
                                    <li>{{ __('common.monthly') }}: <b>{{ config('eosmrtnice.products.ad_types.premium.price_monthly') . config('app.currency_symbol') }}</b></li>
                                    <li>{{ __('common.annual') }}: <b>{{ config('eosmrtnice.products.ad_types.premium.price_annual') . config('app.currency_symbol') }}</b></li>
                                </ol>
                                {!! __('models/ad.info.premium.text') !!}
                            </div>
                            <div class="tab-pane fade py-3 {{ (int)old('type', $ad->type->value) === (int)\App\Enums\AdType::GOLD->value ? 'show active' : '' }}" id="{{ strtolower(\App\Enums\AdType::GOLD->name) }}" role="tabpanel">
                                <h4 class="text-md font-weight-bold mt-2 mb-4">{{ __('models/ad.info.gold.title') }}</h4>
                                <h6>{{ __('models/ad.prices') }}</h6>
                                <ol>
                                    <li>{{ __('common.monthly') }}: <b>{{ config('eosmrtnice.products.ad_types.gold.price_monthly') . config('app.currency_symbol') }}</b></li>
                                    <li>{{ __('common.annual') }}: <b>{{ config('eosmrtnice.products.ad_types.gold.price_annual') . config('app.currency_symbol') }}</b></li>
                                </ol>
                                {!! __('models/ad.info.gold.text') !!}
                            </div>
                        </div>
                    </div>
                </div>
            @endcan

            <h4>{{ __('models/ad.ad_data') }}</h4>
            <hr>

            <div class="form-group row">
                {{-- Title --}}
                <div class="col-lg-6 col-md-12">
                    <x-input-label for="title" :value="__('models/ad.title')"></x-input-label>
                    <x-input-info :content="__('models/ad.title_helper_info')" />
                    <x-text-input id="title"
                                  name="title"
                                  :value="old('title', $ad->title)"
                                  placeholder="{{ __('models/ad.title_placeholder') }}"
                    />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>
                {{-- Months valid --}}
                <div class="col-lg-6 col-md-12">
                    <x-input-label class="d-block" :value="__('models/ad.months_valid')" />
                    <x-input-info class="mb-3" :content="__('models/ad.months_valid_info')"></x-input-info>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input class="custom-control-input" type="radio" name="months_valid" id="months_valid_1" value="1" @checked(old('months_valid', $ad->months_valid) == "1")>
                        <label class="custom-control-label" for="months_valid_1">{{ __('models/ad.months_1') }}</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input class="custom-control-input" type="radio" name="months_valid" id="months_valid_3" value="3" @checked(old('months_valid', $ad->months_valid) == "3")>
                        <label class="custom-control-label" for="months_valid_3">{{ __('models/ad.months_3') }}</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input class="custom-control-input" type="radio" name="months_valid" id="months_valid_6" value="6" @checked(old('months_valid', $ad->months_valid) == "6")>
                        <label class="custom-control-label" for="months_valid_6">{{ __('models/ad.months_6') }}</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input class="custom-control-input" type="radio" name="months_valid" id="months_valid_12" value="12" @checked(old('months_valid', $ad->months_valid) == "12")>
                        <label class="custom-control-label" for="months_valid_12">{{ __('models/ad.months_12') }}</label>
                    </div>
                    <x-input-error :messages="$errors->get('months_valid')" class="mt-2" />
                </div>
            </div>

            {{-- Banner --}}
            <div class="form-group row" id="form-panel-banner">
                <div class="col-12">
                    <x-input-label for="banner" :value="__('models/ad.banner')" :required_tag="true"></x-input-label>
                    <x-input-info :content="__('models/ad.banner_helper_info')" />
                    <input type="file" name="banner" id="banner">
                    <small id="banner-message" class="text-xs font-weight-bold"></small>
                    <x-input-error :messages="$errors->get('banner')" class="mt-2" />
                </div>
            </div>

            {{-- Caption --}}
            <div class="form-group row" id="form-panel-caption">
                <div class="col-12">
                    <x-input-label for="caption" :value="__('models/ad.caption')" />
                    <x-input-info :content="__('models/ad.caption_helper_info')" :required_tag="true"/>
                    <textarea id="caption" name="caption" class="form-control" rows="5">{{ old('caption', $ad->caption) }}</textarea>
                    <x-input-error :messages="$errors->get('caption')" class="mt-2" />
                </div>
            </div>

            <h4 class="mt-5">{{ __('models/ad.company_data') }}</h4>
            <hr>

            {{-- Logo --}}
            <div class="form-group row" id="form-panel-logo">
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <x-input-label for="logo" :value="__('models/company.logo')"></x-input-label>
                    <x-input-info :content="__('models/company.logo_helper_info')" :required_tag="true"/>
                    <input type="file" name="logo" id="logo">
                    <small id="logo-message" class="text-xs font-weight-bold"></small>
                    <x-input-error :messages="$errors->get('logo')" class="mt-2" />
                </div>
            </div>

            {{-- Company type select --}}
            <div class="form-group row">
                <div class="col-lg-4 col-md-12">
                    <x-input-label for="company_type" :value="__('models/ad.company_type')" :required_tag="true"/>
                    <select class="form-control border border-dark" id="company_type" name="company_type">
                        @foreach($companyTypes as $id => $title)
                            <option value="{{ $id }}" @selected((int)old('company_type', $ad->company_type->value) === $id)>{{ $title }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('company_type')" class="mt-2"/>
                </div>
            </div>


            <div class="form-group row">
                {{-- Company title --}}
                <div class="col-lg-4 col-md-12">
                    <x-input-label for="company_title" :value="__('models/ad.company_title')" :required_tag="true"></x-input-label>
                    <x-text-input id="company_title"
                                  name="company_title"
                                  :value="old('company_title', $ad->company_title)"
                                  placeholder="{{ __('models/ad.company_title_placeholder') }}"
                    />
                    <x-input-error :messages="$errors->get('company_title')" class="mt-2" />
                </div>
                {{-- Company address--}}
                <div class="col-lg-8 col-md-12">
                    <x-input-label for="company_address" :value="__('models/ad.company_address')" :required_tag="true"></x-input-label>
                    <x-text-input id="company_address"
                                  name="company_address"
                                  :value="old('company_address', $ad->company_address)"
                                  placeholder="{{ __('models/ad.company_address_placeholder') }}"
                    />
                    <x-input-error :messages="$errors->get('company_address')" class="mt-2" />
                </div>
            </div>

            <div class="form-group row">
                {{-- City id --}}
                <div class="col-lg-4 col-md-12">
                    <x-input-label for="city_id" :value="__('models/ad.city_id')" :required_tag="true"/>
                    <select class="form-control border border-dark" id="city_id" name="city_id">
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}" @selected((int)old('city_id', $ad->city_id) === $city->id)>{{ $city->title }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('city_id')" class="mt-2"/>
                </div>
                {{-- Company website --}}
                <div class="col-lg-8 col-md-12">
                    <x-input-label for="company_website" :value="__('models/ad.company_website')"></x-input-label>
                    <x-text-input id="company_website"
                                  name="company_website"
                                  :value="old('company_website', $ad->company_website)"
                                  placeholder="{{ __('models/ad.company_website_placeholder') }}"
                    />
                    <x-input-error :messages="$errors->get('company_website')" class="mt-2" />
                </div>
            </div>

            <div class="form-group row">
                {{-- Company phone --}}
                <div class="col-lg-6 col-md-12">
                    <x-input-label for="company_phone" :value="__('models/ad.company_phone')"></x-input-label>
                    <x-text-input id="company_phone"
                                  name="company_phone"
                                  :value="old('company_phone', $ad->company_phone)"
                                  placeholder="{{ __('models/ad.company_phone_placeholder') }}"
                    />
                    <x-input-error :messages="$errors->get('company_phone')" class="mt-2" />
                </div>
                {{-- Company mobile phone --}}
                <div class="col-lg-6 col-md-12">
                    <x-input-label for="company_mobile_phone" :value="__('models/ad.company_mobile_phone')"></x-input-label>
                    <x-text-input id="company_mobile_phone"
                                  name="company_mobile_phone"
                                  :value="old('company_mobile_phone', $ad->company_mobile_phone)"
                                  placeholder="{{ __('models/ad.company_mobile_phone_placeholder') }}"
                    />
                    <x-input-error :messages="$errors->get('company_mobile_phone')" class="mt-2" />
                </div>
            </div>

            <div class="form-group row mt-5">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary btn-user">
                        {{ __('common.save') }}
                    </button>
                    <a class="btn btn-link btn-user ml-5" href="{{ $quit }}">
                        {{ __('common.quit') }}
                    </a>
                </div>
            </div>
        </form>
    </div>

    @include('partials.filepond.logo')
    @include('partials.filepond.banner')

    @push('scripts')
        <script type="module">
            const typeMap = {
                '1': 'standard',
                '2': 'premium',
                '3': 'gold',
            }
            /**
             * Toggle logo and/or banner panel
             * @param target
             */
            function toggleFormPanel(target) {

                target = (target === null) ? typeMap['{{ old('type', $ad->type->value) }}'] : target;

                if (target === 'premium') {
                    $('#form-panel-logo').show();
                    $('#form-panel-banner,#form-panel-caption').hide();
                }
                else if (target === 'gold') {
                    $('#form-panel-logo,#form-panel-banner,#form-panel-caption').show();
                }
                else {
                    $('#form-panel-logo,#form-panel-banner,#form-panel-caption').hide();
                }
            }

            $(document).ready(function() {
                toggleFormPanel(null);
                $('input[name="type"]').click(function() {
                    const target = $(this).data('target');
                    $('.tab-content .tab-pane').removeClass('active show');
                    $('#' + target).addClass('active show');
                    toggleFormPanel(target);
                });
            });
        </script>
    @endpush
</x-app-layout>

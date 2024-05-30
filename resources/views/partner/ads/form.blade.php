<x-app-layout>
    <x-slot name="header">
        <h2 class="font-weight-bolder mb-4">
            {{ __('models/ad.ads') }} - {{ __("common.{$action_name}") }} ({{ $company->title }})
        </h2>
        @if($ad->exists)
            <h3 class="font-weight-bolder mb-4">{{ __('models/ad.type') . ': ' . $ad->type->name }}</h3>
        @endif
    </x-slot>

    <div>
        <form method="POST" action="{{ $action }}">
            @csrf
            @if($ad->exists)
                {{ method_field('PUT') }}
            @endif

            {{-- Prevent user from editing ad_type --}}
            @if(!$ad->exists)
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
                                <h1 class="text-md font-weight-bold mt-2 mb-4">{{ __('models/ad.info.standard.title') }}</h1>
                                {!! __('models/ad.info.standard.text') !!}
                            </div>
                            <div class="tab-pane fade py-3 {{ (int)old('type', $ad->type->value) === (int)\App\Enums\AdType::PREMIUM->value ? 'show active' : '' }}" id="{{ strtolower(\App\Enums\AdType::PREMIUM->name) }}" role="tabpanel">
                                <h1 class="text-md font-weight-bold mt-2 mb-4">{{ __('models/ad.info.premium.title') }}</h1>
                                {!! __('models/ad.info.premium.text') !!}
                            </div>
                            <div class="tab-pane fade py-3 {{ (int)old('type', $ad->type->value) === (int)\App\Enums\AdType::GOLD->value ? 'show active' : '' }}" id="{{ strtolower(\App\Enums\AdType::GOLD->name) }}" role="tabpanel">
                                <h1 class="text-md font-weight-bold mt-2 mb-4">{{ __('models/ad.info.gold.title') }}</h1>
                                {!! __('models/ad.info.gold.text') !!}
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Logo --}}
            <div class="form-group row" id="form-panel-logo">
                <div class="col-lg-6 col-md-12 mb-3">
                    <x-input-label for="logo" :value="__('models/company.logo')"></x-input-label>
                    <x-input-info :content="__('models/company.logo_helper_info')" />
                    <input type="file" name="logo" id="logo">
                    <small id="logo-message" class="text-xs font-weight-bold"></small>
                    <x-input-error :messages="$errors->get('logo')" class="mt-2" />
                </div>
            </div>

            {{-- Banner --}}
            <div class="form-group row" id="form-panel-banner">
                <div class="col-12 mb-3">
                    <x-input-label for="banner" :value="__('models/ad.banner')"></x-input-label>
                    <x-input-info :content="__('models/ad.banner_helper_info')" />
                    <input type="file" name="banner" id="banner">
                    <small id="banner-message" class="text-xs font-weight-bold"></small>
                    <x-input-error :messages="$errors->get('banner')" class="mt-2" />
                </div>
            </div>

            {{-- Banner --}}
            <div class="form-group row" id="form-panel-caption">
                <div class="col-12 mb-3">
                    <x-input-label for="caption" :value="__('models/ad.caption')" />
                    <x-input-info :content="__('models/ad.caption_helper_info')" />
                    <textarea id="caption" name="caption" class="form-control" rows="3">{{ old('caption', $ad->caption) }}</textarea>
                    <x-input-error :messages="$errors->get('caption')" class="mt-2" />
                </div>
            </div>

            {{-- months_valid --}}
            <div class="form-group row">
                <div class="col-md-6 mb-3">
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

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-weight-bolder mb-4">
            {{ __('models/ad.ads') }} - {{ __("common.{$action_name}") }}
        </h2>
    </x-slot>

    <div>
        <form method="POST" action="{{ $action }}">
            @csrf
            @if($ad->exists)
                {{ method_field('PUT') }}
            @endif

            <div class="form-group row">
                <div class="col-12 mb-3">
                    <x-input-label class="d-block" :value="__('models/ad.type')"></x-input-label>
                    <div class="btn-group btn-group-lg btn-group-toggle w-100" data-toggle="buttons">
                        <label class="btn rounded-0 btn-secondary {{ old('type', $ad->type) === \App\Enums\AdType::STANDARD ? 'active' : '' }}">
                            <i class="fas fa-check-circle"></i>
                            <br>
                            <input role="tab" type="radio" name="type" value="{{ \App\Enums\AdType::STANDARD }}" {{ old('type', $ad->type) === \App\Enums\AdType::STANDARD ? 'checked' : '' }} data-target="{{ strtolower(\App\Enums\AdType::STANDARD->name) }}">
                            {{ \App\Enums\AdType::STANDARD->translate() }}
                        </label>
                        <label class="btn rounded-0 btn-secondary {{ old('type', $ad->type) === \App\Enums\AdType::PREMIUM ? 'active' : '' }}">
                            <i class="fas fa-medal"></i>
                            <br>
                            <input type="radio" name="type" value="{{ \App\Enums\AdType::PREMIUM }}" {{ old('type', $ad->type) === \App\Enums\AdType::PREMIUM ? 'checked' : '' }} data-target="{{ strtolower(\App\Enums\AdType::PREMIUM->name) }}">
                            {{ \App\Enums\AdType::PREMIUM->translate() }}
                        </label>
                        <label class="btn rounded-0 btn-secondary {{ old('type', $ad->type) === \App\Enums\AdType::GOLD ? 'active' : '' }}">
                            <i class="fas fa-gem"></i>
                            <br>
                            <input type="radio" name="type" value="{{ \App\Enums\AdType::GOLD }}" {{ old('type', $ad->type) === \App\Enums\AdType::GOLD ? 'checked' : '' }} data-target="{{ strtolower(\App\Enums\AdType::GOLD->name) }}">
                            {{ \App\Enums\AdType::GOLD->translate() }}
                        </label>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade py-3 show active" id="{{ strtolower(\App\Enums\AdType::STANDARD->name) }}" role="tabpanel">
                            <h1 class="text-md font-weight-bold mt-2 mb-4">{{ __('models/ad.info.standard.title') }}</h1>
                            {!! __('models/ad.info.standard.text') !!}
                        </div>
                        <div class="tab-pane fade py-3" id="{{ strtolower(\App\Enums\AdType::PREMIUM->name) }}" role="tabpanel">
                            <h1 class="text-md font-weight-bold mt-2 mb-4">{{ __('models/ad.info.premium.title') }}</h1>
                            {!! __('models/ad.info.premium.text') !!}
                        </div>
                        <div class="tab-pane fade py-3" id="{{ strtolower(\App\Enums\AdType::GOLD->name) }}" role="tabpanel">
                            <h1 class="text-md font-weight-bold mt-2 mb-4">{{ __('models/ad.info.gold.title') }}</h1>
                            {!! __('models/ad.info.gold.text') !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-6">
                    <x-input-label class="d-block" :value="__('models/ad.months_valid')" />
                    <x-input-info :content="__('models/ad.months_valid_info')"></x-input-info>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input class="custom-control-input" type="radio" name="months_valid" id="months_valid_1" value="1" checked>
                        <label class="custom-control-label" for="months_valid_1">{{ __('models/ad.months_1') }}</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input class="custom-control-input" type="radio" name="months_valid" id="months_valid_3" value="3">
                        <label class="custom-control-label" for="months_valid_3">{{ __('models/ad.months_3') }}</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input class="custom-control-input" type="radio" name="months_valid" id="months_valid_6" value="6">
                        <label class="custom-control-label" for="months_valid_6">{{ __('models/ad.months_6') }}</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input class="custom-control-input" type="radio" name="months_valid" id="months_valid_12" value="12">
                        <label class="custom-control-label" for="months_valid_12">{{ __('models/ad.months_12') }}</label>
                    </div>
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
    @push('scripts')
        <script type="module">
            $(document).ready(function() {
                $('input[name="type"]').click(function() {
                    const target = $(this).data('target');
                    $('.tab-content .tab-pane').removeClass('active show');
                    $('#' + target).addClass('active show');
                });
            });
        </script>
    @endpush
</x-app-layout>

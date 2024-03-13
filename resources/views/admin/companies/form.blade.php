<x-app-layout>
    <x-slot name="header">
        <h2 class="font-weight-bolder mb-4">
            {{ __('admin.companies') }} - {{ __("common.{$action_name}") }}
        </h2>
    </x-slot>

    <div>
        <form method="POST" action="{{ $action }}">
            @csrf
            {{ method_field('PUT') }}
            <div class="form-group row">
                <div class="col-lg-6 col-sm-12 my-2">
                    <x-input-label for="title" :value="__('admin.company_title')" />
                    <x-text-input
                        id="title"
                        type="text"
                        name="title"
                        :value="old('title', $company->title)"
                        placeholder="{{ __('admin.placeholders.company_title') }}"/>
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-6 col-md-8 my-2">
                    <x-input-label for="address" :value="__('admin.company_address')" />
                    <x-text-input
                        id="address"
                        type="text"
                        name="address"
                        :value="old('address', $company->address)"
                        placeholder="{{ __('admin.placeholders.company_address') }}"/>
                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                </div>
                <div class="col-lg-4 col-md-8 my-2">
                    <x-input-label for="town" :value="__('admin.company_town')" />
                    <x-text-input
                        id="town"
                        type="text"
                        name="town"
                        :value="old('town', $company->town)"
                        placeholder="{{ __('admin.placeholders.company_town') }}"/>
                    <x-input-error :messages="$errors->get('town')" class="mt-2" />
                </div>
                <div class="col-lg-2 col-md-4 my-2">
                    <x-input-label for="zipcode" :value="__('admin.company_zipcode')" />
                    <x-text-input
                        id="zipcode"
                        type="text"
                        name="zipcode"
                        :value="old('zipcode', $company->zipcode)"
                        placeholder="{{ __('admin.placeholders.company_zipcode') }}"/>
                    <x-input-error :messages="$errors->get('zipcode')" class="mt-2" />
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-6 col-sm-12 my-2">
                    <x-input-label for="oib" :value="__('admin.company_oib')" />
                    <x-text-input
                        id="oib"
                        type="text"
                        name="oib"
                        :value="old('oib', $company->oib)"
                        placeholder="{{ __('admin.placeholders.company_oib') }}"/>
                    <x-input-error :messages="$errors->get('oib')" class="mt-2" />
                </div>
                <div class="col-md-6 col-sm-12 my-2">
                    <x-input-label for="email" :value="__('admin.company_email')" />
                    <x-text-input
                        id="email"
                        type="email"
                        name="email"
                        :value="old('email', $company->email)"
                        placeholder="{{ __('admin.placeholders.company_email') }}"/>
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
            <div class="form-group row">
                <div class="col-md-6 col-sm-12 my-2">
                    <x-input-label for="phone" :value="__('admin.company_phone')" />
                    <x-text-input
                        id="phone"
                        type="text"
                        name="phone"
                        :value="old('phone', $company->phone)"
                        placeholder="{{ __('admin.placeholders.company_phone') }}"/>
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>
                <div class="col-md-6 col-sm-12 my-2">
                    <x-input-label for="mobile_phone" :value="__('admin.company_mobile_phone')" />
                    <x-text-input
                        id="mobile_phone"
                        type="text"
                        name="mobile_phone"
                        :value="old('mobile_phone', $company->mobile_phone)"
                        placeholder="{{ __('admin.placeholders.mobile_phone') }}"/>
                    <x-input-error :messages="$errors->get('mobile_phone')" class="mt-2" />
                </div>
            </div>
            <div class="form-group row">
                <div class="col-2 my-2">
                    <div class="custom-control custom-switch">
                        <input name="active" type="checkbox" class="custom-control-input" id="activeSwitch" {{ $company->active ? "checked" : "" }}>
                        <label class="custom-control-label" for="activeSwitch">{{ __('admin.is_active') }}</label>
                    </div>
                </div>
            </div>
            <div class="form-group row mt-5">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary btn-user">
                        {{ __('common.save') }}
                    </button>
                    <a class="btn btn-link btn-user ml-5" href="{{ url()->previous() }}">
                        {{ __('common.quit') }}
                    </a>
                </div>
            </div>
        </form>
    </div>

</x-app-layout>

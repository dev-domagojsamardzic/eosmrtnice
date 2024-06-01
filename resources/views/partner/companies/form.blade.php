<x-app-layout>
    <x-slot name="header">
        <h2 class="font-weight-bolder mb-4">
            {{ __('admin.companies') }} - {{ __("common.{$action_name}") }}
        </h2>
    </x-slot>

    <div>
        <form method="POST" action="{{ $action }}" enctype="multipart/form-data">
            @csrf
            @if($company->exists)
                {{ method_field('PUT') }}
            @endif

            {{-- Logo --}}
            <div class="form-group row">
                <div class="col-lg-6 col-md-12 mb-3">
                    <x-input-label for="logo" :value="__('models/company.logo')"></x-input-label>
                    <x-input-info :content="__('models/company.logo_helper_info')" />
                    <input type="file" name="logo" id="logo">
                    <small id="logo-message" class="text-xs font-weight-bold"></small>
                </div>
            </div>

            {{-- website --}}
            <div class="form-group row">
                <div class="col-lg-6 col-md-12 mb-3">
                    <x-input-label for="website" :value="__('models/company.website')"></x-input-label>
                    <x-text-input
                        id="website"
                        name="website"
                        type="text"
                        :value="old('website', $company->website)"
                        placeholder="{{ __('models/company.placeholders.website') }}"/>
                    <x-input-error :messages="$errors->get('website')" class="mt-2" />
                </div>
            </div>


            <div class="form-group row">
                {{-- type --}}
                <div class="col-lg-6 col-sm-12 mb-3">
                    <x-input-label for="type" :value="__('admin.labels.company_type')" :required_tag="true"/>
                    <select class="form-control border border-dark" name="type" id="type">
                        @foreach($types as $value => $type)
                            @if((int)old('type') === $value)
                                <option value="{{ $value }}" selected>{{ $type }}</option>
                            @elseif($company->type === $value)
                                <option value="{{ $value }}" selected>{{ $type }}</option>
                            @else
                                <option value="{{ $value }}">{{ $type }}</option>
                            @endif
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('type')" class="mt-2" />
                </div>
            </div>

            <div class="form-group row">
                {{-- title --}}
                <div class="col-lg-6 mb-3">
                    <x-input-label for="title" :value="__('admin.labels.company_title')" :required_tag="true"/>
                    <x-text-input
                        id="title"
                        type="text"
                        name="title"
                        :value="old('title', $company->title)"
                        required
                        placeholder="{{ __('admin.placeholders.company_title') }}"/>
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>
            </div>

            <div class="form-group row">
                {{-- county_id --}}
                <div class="col-md-6 mb-3">
                    <x-input-label for="county_id" :value="__('auth.labels.company_county')" :required_tag="true"/>
                    <select class="form-control border border-dark" id="county_id" name="county_id">
                        @foreach($counties as $county)
                            @if((int) old('county_id', $company->county_id) === $county->id)
                                <option value="{{ $county->id }}" selected>{{ $county->title }}</option>
                            @else
                                <option value="{{ $county->id }}">{{ $county->title }}</option>
                            @endif
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('county_id')" class="mt-2"/>
                </div>

                {{-- city_id --}}
                <div class="col-md-6 mb-3">
                    <x-input-label for="city_id" :value="__('auth.labels.company_city')" :required_tag="true"/>
                    <select class="form-control border border-dark" id="city_id" name="city_id">
                        @foreach($cities as $city)
                            @if((int) old('city_id', $company->city_id) === $city->id)
                                <option value="{{ $city->id }}" selected>{{ $city->title }}</option>
                            @else
                                <option value="{{ $city->id }}">{{ $city->title }}</option>
                            @endif
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('city_id')" class="mt-2"/>
                </div>

                {{-- address --}}
                <div class="col-sm-12 mb-2">
                    <x-input-label for="address" :value="__('admin.labels.company_address')" />
                    <x-text-input
                        id="address"
                        type="text"
                        name="address"
                        :value="old('address', $company->address)"
                        placeholder="{{ __('admin.placeholders.company_address') }}"/>
                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                </div>

                {{-- town --}}
                <div class="col-md-8 mb-2">
                    <x-input-label for="town" :value="__('admin.labels.company_town')" />
                    <x-text-input
                        id="town"
                        type="text"
                        name="town"
                        :value="old('town', $company->town)"
                        placeholder="{{ __('admin.placeholders.company_town') }}"/>
                    <x-input-error :messages="$errors->get('town')" class="mt-2" />
                </div>

                {{-- zipcode --}}
                <div class="col-md-4 mb-2">
                    <x-input-label for="zipcode" :value="__('admin.labels.company_zipcode')" />
                    <x-text-input
                        id="zipcode"
                        type="text"
                        name="zipcode"
                        maxlength="5"
                        :value="old('zipcode', $company->zipcode)"
                        placeholder="{{ __('admin.placeholders.company_zipcode') }}"/>
                    <x-input-error :messages="$errors->get('zipcode')" class="mt-2" />
                </div>
            </div>

            <div class="form-group row">
                {{-- oib --}}
                <div class="col-md-6 mb-2">
                    <x-input-label for="oib" :value="__('admin.oib')" :required_tag="true"/>
                    <x-text-input
                        id="oib"
                        type="text"
                        name="oib"
                        maxlength="11"
                        :value="old('oib', $company->oib)"
                        required
                        placeholder="{{ __('admin.placeholders.company_oib') }}"/>
                    <x-input-error :messages="$errors->get('oib')" class="mt-2" />
                </div>

                {{-- email --}}
                <div class="col-md-6 mb-2">
                    <x-input-label for="email" :value="__('admin.labels.company_email')"/>
                    <x-input-info style="display:inline-block;" :content="__('models/company.logo_helper_info')" inline/>
                    <x-text-input
                        id="email"
                        type="email"
                        name="email"
                        :value="old('email', $company->email)"
                        required
                        placeholder="{{ __('admin.placeholders.company_email') }}"/>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>


                {{-- phone --}}
                <div class="col-md-6 col-sm-12 my-2">
                    <x-input-label for="phone" :value="__('admin.labels.company_phone')" />
                    <x-text-input
                        id="phone"
                        type="text"
                        name="phone"
                        :value="old('phone', $company->phone)"
                        placeholder="{{ __('admin.placeholders.company_phone') }}"/>
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>

                {{-- mobile_phone --}}
                <div class="col-md-6 col-sm-12 my-2">
                    <x-input-label for="mobile_phone" :value="__('admin.labels.company_mobile_phone')" />
                    <x-text-input
                        id="mobile_phone"
                        type="text"
                        name="mobile_phone"
                        :value="old('mobile_phone', $company->mobile_phone)"
                        placeholder="{{ __('admin.placeholders.company_mobile_phone') }}"/>
                    <x-input-error :messages="$errors->get('mobile_phone')" class="mt-2" />
                </div>
            </div>

            <div class="form-group row">
                <div class="col-2 my-2">
                    <div class="custom-control custom-switch">
                        <input name="active" type="checkbox" class="custom-control-input" id="activeSwitch" {{ $company->active ? "checked" : "" }}>
                        <label class="custom-control-label" for="activeSwitch">{{ __('common.is_active_f') }}</label>
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
    @include('partials.filepond.logo')
</x-app-layout>

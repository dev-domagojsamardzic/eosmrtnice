<x-guest-layout>

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-flex flex-column align-items-center justify-content-center px-3 py-5 bg-register-image">
                        <img class="my-4" height="120" alt="{{ config('app.name') }}" src="{{ asset('storage/images/logo_vector_black.svg') }}">
                        <img class="my-4" height="200" alt="{{ config('app.name') }}" src="{{ asset('storage/images/partner.svg') }}">
                    </div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-left">
                                <h1 class="h4 text-gray-900 mb-4">{{ __('auth.looking_forward_cooperating') }}</h1>
                            </div>
                            <div class="text-left">
                                <h4>{{ __('auth.partner_representative_user') }}</h4>
                            </div>
                            <form  method="POST" action="{{ route('partner.register') }}">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <x-input-label for="first_name" :value="__('auth.labels.first_name')" />
                                        <x-text-input
                                            id="first_name"
                                            type="text"
                                            name="first_name"
                                            :value="old('first_name')"
                                            required autofocus autocomplete
                                            placeholder="{{ __('auth.placeholders.first_name') }}"/>
                                    </div>
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <x-input-label for="last_name" :value="__('auth.labels.last_name')" />
                                        <x-text-input
                                            id="last_name"
                                            type="text"
                                            name="last_name"
                                            :value="old('last_name')"
                                            required autofocus autocomplete
                                            placeholder="{{ __('auth.placeholders.last_name') }}"/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                        <x-input-label class="d-block" for="sex" :value="__('auth.labels.sex')" />
                                        @php
                                            $options = \App\Enums\UserSex::options();
                                        @endphp
                                        <x-input-radio-inline name="sex" :options="$options" :selected="\App\Enums\UserSex::MALE->value"></x-input-radio-inline>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <x-input-label for="email" :value="__('auth.labels.email')" />
                                    <x-text-input
                                        id="email"
                                        type="email"
                                        name="email"
                                        :value="old('email')"
                                        required autofocus autocomplete
                                        placeholder="{{ __('auth.placeholders.email') }}"/>
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <x-input-label for="password" :value="__('auth.labels.password')" />
                                        <x-text-input id="password"
                                                      type="password"
                                                      name="password"
                                                      placeholder="{{ __('auth.placeholders.password') }}"
                                                      required/>
                                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                    </div>
                                    <div class="col-sm-6">
                                        <x-input-label for="password" :value="__('auth.labels.confirm_password')" />
                                        <x-text-input id="password_confirmation"
                                                      type="password"
                                                      name="password_confirmation"
                                                      placeholder="{{ __('auth.placeholders.confirm_password') }}"
                                                      required/>
                                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                    </div>
                                </div>

                                <hr class="my-4">

                                {{-- Company data --}}
                                <div class="text-left">
                                    <h4>{{ __('auth.company_data') }}</h4>
                                </div>

                                <div class="form-group">
                                    <x-input-label for="company_title" :value="__('auth.labels.company_title')" />
                                    <x-text-input
                                        id="company_title"
                                        type="text"
                                        name="company_title"
                                        :value="old('company_title')"
                                        required autofocus
                                        autocomplete="company_title"
                                        placeholder="{{ __('auth.placeholders.company_title') }}"/>
                                    <x-input-error :messages="$errors->get('company_title')" class="mt-2" />
                                </div>

                                <div class="form-group">
                                    <x-input-label for="company_address" :value="__('auth.labels.company_address')" />
                                    <x-text-input
                                        id="company_address"
                                        type="text"
                                        name="company_address"
                                        :value="old('company_address')"
                                        autocomplete="company_address"
                                        required
                                        placeholder="{{ __('auth.placeholders.company_address') }}"/>
                                    <x-input-error :messages="$errors->get('company_address')" class="mt-2" />
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-8 mb-3 mb-sm-0">
                                        <x-input-label for="company_town" :value="__('auth.labels.company_town')" />
                                        <x-text-input id="company_town"
                                                      type="text"
                                                      name="company_town"
                                                      :value="old('company_town')"
                                                      placeholder="{{ __('auth.placeholders.company_town') }}"
                                                      required
                                                      autocomplete="company_town" />
                                        <x-input-error :messages="$errors->get('company_town')" class="mt-2" />
                                    </div>
                                    <div class="col-sm-4">
                                        <x-input-label for="company_zipcode" :value="__('auth.labels.company_zipcode')" />
                                        <x-text-input id="company_zipcode"
                                                      type="text"
                                                      name="company_zipcode"
                                                      :value="old('company_zipcode')"
                                                      placeholder="{{ __('auth.placeholders.company_zipcode') }}"
                                                      required
                                                      autocomplete="company_zipcode" />
                                        <x-input-error :messages="$errors->get('company_zipcode')" class="mt-2" />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <x-input-label for="county_id" :value="__('auth.labels.company_county')" />
                                        <select class="form-control" id="county_id" name="county_id">
                                            @foreach($counties as $id => $county)
                                                <option value="{{ $id }}">{{ $county }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <x-input-label for="company_oib" :value="__('auth.labels.company_oib')" />
                                    <x-text-input
                                        id="company_oib"
                                        type="text"
                                        name="company_oib"
                                        :value="old('company_oib')"
                                        required
                                        placeholder="{{ __('auth.placeholders.company_oib') }}"/>
                                    <x-input-error :messages="$errors->get('company_oib')" class="mt-2" />
                                </div>

                                <div class="form-group">
                                    <x-input-label for="company_email" :value="__('auth.labels.company_email')" />
                                    <x-text-input
                                        id="company_email"
                                        type="text"
                                        name="company_email"
                                        :value="old('company_email')"
                                        autocomplete
                                        placeholder="{{ __('auth.placeholders.company_email') }}"/>
                                    <x-input-error :messages="$errors->get('company_email')" class="mt-2" />
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <x-input-label for="company_phone" :value="__('auth.labels.company_phone')" />
                                        <x-text-input id="company_phone"
                                                      type="text"
                                                      name="company_phone"
                                                      :value="old('company_phone')"
                                                      placeholder="{{ __('auth.placeholders.company_phone') }}"
                                                      autocomplete="company_phone" />
                                        <x-input-error :messages="$errors->get('company_phone')" class="mt-2" />
                                    </div>
                                    <div class="col-sm-6">
                                        <x-input-label for="company_mobile_phone" :value="__('auth.labels.company_mobile')" />
                                        <x-text-input id="company_mobile_phone"
                                                      type="text"
                                                      name="company_mobile_phone"
                                                      :value="old('company_mobile_phone')"
                                                      placeholder="{{ __('auth.placeholders.company_mobile') }}"
                                                      autocomplete="company_mobile_phone" />
                                        <x-input-error :messages="$errors->get('company_mobile_phone')" class="mt-2" />
                                    </div>
                                </div>

                                <x-primary-button class="mt-5">
                                    {{ __('auth.register') }}
                                </x-primary-button>
                            </form>
                            <hr>
                            @if (Route::has('password.request'))
                                <div class="text-center">
                                    <a class="small" href="{{ route('password.request') }}">{{ __('auth.labels.forgot_password') }}</a>
                                </div>
                            @endif
                            <div class="text-center">
                                <a class="small" href="{{ route('login') }}">{{ __('auth.labels.already_have_account_login') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>

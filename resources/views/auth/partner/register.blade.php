<x-guest-layout>

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div
                        class="col-lg-5 d-none d-flex flex-column align-items-center justify-content-start px-3 py-5 bg-register-image">
                        <img class="my-4" alt="{{ config('app.name') }}" src="{{ asset('graphics/logo/logo-dark.svg') }}">
                        <h3 class="text-gray-900 mb-4 font-weight-bold">{{ __('common.partners') }}</h3>
                        <img class="my-4" alt="{{ config('app.name') }}" src="{{ asset('graphics/symbol/partner.svg') }}">
                    </div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-left font-weight-bold mb-3">
                                <h1 class="mb-2">{{ __('auth.become_our_partner') }}</h1>
                                <h5 class="mb-4">{{ __('auth.looking_forward_cooperating') }}</h5>
                            </div>

                            <hr class="mb-4">

                            <div class="text-left mb-3">
                                <h5>{{ __('auth.partner_representative_user') }}</h5>
                            </div>

                            <form method="POST" action="{{ route('partner.register.store') }}">
                                @csrf
                                {{-- first_name & last_name --}}
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3">
                                        <x-input-label for="first_name" :value="__('auth.labels.first_name')" :required_tag="true"/>
                                        <x-text-input
                                            id="first_name"
                                            type="text"
                                            name="first_name"
                                            :value="old('first_name')"
                                            required autofocus
                                            placeholder="{{ __('auth.placeholders.first_name') }}"/>
                                        <x-input-error :messages="$errors->get('first_name')" class="mt-2"/>
                                    </div>
                                    <div class="col-sm-6 mb-3">
                                        <x-input-label for="last_name" :value="__('auth.labels.last_name')" :required_tag="true"/>
                                        <x-text-input
                                            id="last_name"
                                            type="text"
                                            name="last_name"
                                            :value="old('last_name')"
                                            required
                                            placeholder="{{ __('auth.placeholders.last_name') }}"/>
                                        <x-input-error :messages="$errors->get('last_name')" class="mt-2"/>
                                    </div>
                                </div>

                                {{-- gender --}}
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3">
                                        <x-input-label class="d-block" for="gender" :value="__('auth.labels.gender')"/>
                                        <x-input-radio-inline name="gender"
                                                              :options="$genders"
                                                              :selected="$gender_default">
                                        </x-input-radio-inline>
                                    </div>
                                </div>

                                {{-- birthday --}}
                                <div class="form-group row">
                                    <div class="col-sm-12 col-md-6 mb-3 mb-sm-0">
                                        <x-input-label for="birthday" :value="__('auth.labels.birthday')"></x-input-label>
                                        <x-input-info :content="__('auth.birthday_info')" />
                                        <div class="input-group input-group-joined date">
                                            <input name="birthday"
                                                   id="birthday"
                                                   type="text"
                                                   placeholder="dd.mm.yyyy."
                                                   value="{{ old('birthday') }}"
                                                   class="form-control datepicker" autocomplete="off">
                                            <span class="input-group-text">
                                                <i class="fas fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <x-input-error :messages="$errors->get('birthday')" class="mt-2"/>
                                    </div>
                                </div>

                                {{-- email --}}
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3">
                                        <x-input-label for="email" :value="__('auth.labels.email')"/>
                                        <x-text-input
                                            id="email"
                                            type="email"
                                            name="email"
                                            :value="old('email')"
                                            required
                                            placeholder="{{ __('auth.placeholders.email') }}"/>
                                        <x-input-error :messages="$errors->get('email')" class="mt-2"/>
                                    </div>
                                </div>
                                {{-- password & confirm_password--}}
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3">
                                        <x-input-label for="password" :value="__('auth.labels.password')"/>
                                        <x-input-info :content="__('auth.password_rules')" />
                                        <x-text-input id="password"
                                                      type="password"
                                                      name="password"
                                                      placeholder="{{ __('auth.placeholders.password') }}"
                                                      required/>
                                        <x-input-error :messages="$errors->get('password')" class="mt-2"/>
                                    </div>
                                    <div class="col-sm-12">
                                        <x-input-label for="password" :value="__('auth.labels.confirm_password')"/>
                                        <x-text-input id="password_confirmation"
                                                      type="password"
                                                      name="password_confirmation"
                                                      placeholder="{{ __('auth.placeholders.confirm_password') }}"
                                                      required/>
                                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2"/>
                                    </div>
                                </div>

                                <hr class="my-4">

                                {{-- Company data --}}
                                <div class="text-left mb-4">
                                    <h5>{{ __('auth.company_data') }}</h5>
                                </div>

                                {{-- company_title --}}
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3">
                                        <x-input-label for="company_title" :value="__('auth.labels.company_title')" :required_tag="true"/>
                                        <x-text-input
                                            id="company_title"
                                            type="text"
                                            name="company_title"
                                            :value="old('company_title')"
                                            required
                                            autocomplete="company_title"
                                            placeholder="{{ __('auth.placeholders.company_title') }}"/>
                                        <x-input-error :messages="$errors->get('company_title')" class="mt-2"/>
                                    </div>
                                </div>

                                {{-- company_address --}}
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3">
                                        <x-input-label for="company_address" :value="__('auth.labels.company_address')"/>
                                        <x-text-input
                                            id="company_address"
                                            type="text"
                                            name="company_address"
                                            :value="old('company_address')"
                                            autocomplete="company_address"
                                            placeholder="{{ __('auth.placeholders.company_address') }}"/>
                                        <x-input-error :messages="$errors->get('company_address')" class="mt-2"/>
                                    </div>
                                </div>

                                {{-- company_town & company_zipcode --}}
                                <div class="form-group row">
                                    <div class="col-sm-8 mb-3">
                                        <x-input-label for="company_town" :value="__('auth.labels.company_town')" />
                                        <x-text-input
                                            id="company_town"
                                            type="text"
                                            name="text"
                                            :value="old('company_town')"
                                            autocomplete="company_town"
                                            placeholder="{{ __('auth.placeholders.company_town') }}"></x-text-input>
                                        <x-input-error :messages="$errors->get('company_town')" class="mt-2"/>
                                    </div>
                                    <div class="col-sm-4 mb-3">
                                        <x-input-label for="company_zipcode" :value="__('auth.labels.company_zipcode')" />
                                        <x-text-input
                                            id="company_zipcode"
                                            type="text"
                                            maxlength="5"
                                            name="company_zipcode"
                                            :value="old('company_zipcode')"
                                            autocomplete="{{ __('auth.placeholders.company_zipcode') }}"
                                            placeholder="{{ __('auth.placeholders.company_zipcode') }}"></x-text-input>
                                        <x-input-error :messages="$errors->get('company_zipcode')" class="mt-2"/>
                                    </div>
                                </div>

                                {{-- company_oib --}}
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3">
                                        <x-input-label for="company_oib" :value="__('auth.labels.company_oib')" :required_tag="true"/>
                                        <x-text-input
                                            id="company_oib"
                                            type="text"
                                            name="company_oib"
                                            :value="old('company_oib')"
                                            maxlength="11"
                                            required
                                            placeholder="{{ __('auth.placeholders.company_oib') }}"/>
                                        <x-input-error :messages="$errors->get('company_oib')" class="mt-2"/>
                                    </div>
                                </div>

                                {{-- company_email --}}
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3">
                                        <x-input-label for="company_email" :value="__('auth.labels.company_email')" :required_tag="true"/>
                                        <x-input-info :content="__('models/company.company_email_info')" />
                                        <x-text-input
                                            id="company_email"
                                            type="text"
                                            name="company_email"
                                            :value="old('company_email')"
                                            autocomplete="email"
                                            placeholder="{{ __('auth.placeholders.company_email') }}"/>
                                        <x-input-error :messages="$errors->get('company_email')" class="mt-2"/>
                                    </div>
                                </div>

                                {{-- company_phone --}}
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3">
                                        <x-input-label for="company_phone" :value="__('auth.labels.company_phone')"/>
                                        <x-text-input id="company_phone"
                                                      type="text"
                                                      name="company_phone"
                                                      :value="old('company_phone')"
                                                      placeholder="{{ __('auth.placeholders.company_phone') }}"
                                                      autocomplete="company_phone"/>
                                        <x-input-error :messages="$errors->get('company_phone')" class="mt-2"/>
                                    </div>
                                    <div class="col-sm-6 mb-3">
                                        <x-input-label for="company_mobile_phone" :value="__('auth.labels.company_mobile')"/>
                                        <x-text-input id="company_mobile_phone"
                                                      type="text"
                                                      name="company_mobile_phone"
                                                      :value="old('company_mobile_phone')"
                                                      placeholder="{{ __('auth.placeholders.company_mobile') }}"
                                                      autocomplete="company_mobile_phone"/>
                                        <x-input-error :messages="$errors->get('company_mobile_phone')" class="mt-2"/>
                                    </div>
                                </div>

                                <x-primary-button class="mt-5">
                                    {{ __('auth.register') }}
                                </x-primary-button>
                            </form>
                            <hr>
                            <div class="text-center mb-3">
                                <a class="small"
                                   href="{{ route('login') }}">{{ __('auth.labels.already_have_account_login') }}</a>
                            </div>
                            @if (Route::has('password.request'))
                                <div class="text-center">
                                    <a class="small"
                                       href="{{ route('password.request') }}">{{ __('auth.labels.forgot_password') }}</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>

<script type="module">
    document.addEventListener('DOMContentLoaded', function () {
        $('#birthday').datepicker({
            dateFormat: "dd.mm.yy.",
            autoSize: true,
            language: "hr",
            maxDate: '{{ now()->format('d.m.Y.') }}',
        });
    });
</script>

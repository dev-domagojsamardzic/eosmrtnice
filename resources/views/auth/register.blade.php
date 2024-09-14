<x-guest-layout>

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div
                        class="col-lg-5 d-none d-flex align-items-center justify-content-center flex-column px-3 py-5 bg-register-image">
                        <img height="đ" width="auto" alt="{{ config('app.name') }}" src="{{ asset('graphics/logo/logo-dark.svg') }}">
                        <h1 class="text-gray-900 mb-4 font-weight-normal">{{ config('app.name') }}</h1>
                    </div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-left">
                                <h2 class="text-gray-900 mb-4">{{ __('auth.register') }}</h2>
                            </div>
                            <form method="POST" action="{{ route('register.store') }}">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <x-input-label for="first_name" :value="__('auth.labels.first_name')"/>
                                        <x-text-input
                                            id="first_name"
                                            type="text"
                                            name="first_name"
                                            :value="old('first_name')"
                                            required autofocus autocomplete
                                            placeholder="{{ __('auth.placeholders.first_name') }}"/>
                                    </div>
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <x-input-label for="last_name" :value="__('auth.labels.last_name')"/>
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
                                        <x-input-label class="d-block" for="gender" :value="__('auth.labels.gender')"/>
                                        @php
                                            $options = \App\Enums\Gender::options();
                                        @endphp
                                        <x-input-radio-inline name="gender" :options="$options"
                                                              :selected="\App\Enums\Gender::MALE->value"></x-input-radio-inline>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <x-input-label for="email" :value="__('auth.labels.email')"/>
                                    <x-text-input
                                        id="email"
                                        type="email"
                                        name="email"
                                        :value="old('email')"
                                        required autofocus autocomplete
                                        placeholder="{{ __('auth.placeholders.email') }}"/>
                                    <x-input-error :messages="$errors->get('email')" class="mt-2"/>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3">
                                        <x-input-label for="password" :value="__('auth.labels.password')"/>
                                        <x-input-info :content="__('auth.password_rules')" />
                                        <x-text-input id="password"
                                                      type="password"
                                                      name="password"
                                                      placeholder="{{ __('auth.placeholders.password') }}"
                                                      required autocomplete="current-password"/>
                                        <x-input-error :messages="$errors->get('password')" class="mt-2"/>
                                    </div>

                                    <div class="col-sm-12">
                                        <x-input-label for="password" :value="__('auth.labels.confirm_password')"/>
                                        <x-text-input id="password_confirmation"
                                                      type="password"
                                                      name="password_confirmation"
                                                      placeholder="{{ __('auth.placeholders.confirm_password') }}"
                                                      required autocomplete="new-password"/>
                                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2"/>
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


                            <hr>
                            <div class="text-center">
                                <a class="font-weight-bold" href="{{ route('partner.register') }}">{{ __('auth.become_a_partner') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>

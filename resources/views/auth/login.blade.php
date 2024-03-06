<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-flex align-items-center justify-content-center px-3 py-5 bg-login-image">
                                <img height="250" width="auto" alt="{{ config('app.name') }}" src="{{ asset('storage/images/cross.svg') }}">
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-left">
                                        <h1 class="h4 text-gray-900 mb-4">{{ config('app.name') }}</h1>
                                    </div>
                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf
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
                                        <div class="form-group">
                                            <x-input-label for="password" :value="__('auth.labels.password')" />
                                            <x-text-input id="password"
                                                          type="password"
                                                          name="password"
                                                          placeholder="{{ __('auth.placeholders.password') }}"
                                                          required autocomplete="current-password" />
                                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="remember_me" id="remember_me">
                                                <label class="custom-control-label" for="remember_me">
                                                    {{ __('auth.labels.remember_me') }}
                                                </label>
                                            </div>
                                        </div>
                                        <x-primary-button class="mt-4">
                                            {{ __('auth.log_in') }}
                                        </x-primary-button>
                                    </form>
                                    <hr>
                                    @if (Route::has('password.request'))
                                        <div class="text-center">
                                            <a class="small" href="{{ route('password.request') }}">{{ __('auth.labels.forgot_password') }}</a>
                                        </div>
                                    @endif

                                    <div class="text-center">
                                        <a class="small" href="{{ route('register') }}">{{ __('auth.create_account') }}</a>
                                    </div>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="{{ route('partner.register') }}">{{ __('auth.become_a_partner') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>

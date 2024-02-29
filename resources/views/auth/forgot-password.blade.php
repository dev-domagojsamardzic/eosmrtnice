<x-guest-layout>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="d-flex justify-content-center align-items-center col-lg-5 d-none px-3 py-5">
                                <img height="300" width="auto" alt="{{ config('app.name') }}" src="{{ asset('storage/images/cross.svg') }}">
                            </div>
                            <div class="col-lg-7">
                                <div class="p-5">
                                    <div class="text-left">
                                        <h1 class="h4 text-gray-900 mb-2">{{ __('auth.forgot_password_title') }}</h1>
                                        <p class="mb-4">
                                            {{ __('auth.forgot_password_text') }}
                                        </p>
                                    </div>
                                    <form method="POST" action="{{ route('password.email') }}">
                                        @csrf
                                        <div class="form-group">
                                            <x-input-label for="email" :value="__('auth.labels.email')" />
                                            <x-text-input id="email"
                                                          type="email"
                                                          name="email"
                                                          placeholder="{{ __('auth.placeholders.email') }}"
                                                          :value="old('email')"
                                                          required autofocus />
                                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                        </div>
                                        <x-primary-button>
                                            {{ __('auth.email_password_reset_link') }}
                                        </x-primary-button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="{{ route('register') }}">{{ __('auth.create_account') }}</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="{{ route('login') }}">{{ __('auth.labels.already_have_account_login') }}</a>
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

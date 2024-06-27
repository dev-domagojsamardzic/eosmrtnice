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
                            <div class="d-flex justify-content-center align-items-center col-lg-5 d-none px-3 py-5 bg-confirm-password-image">
                                <img height="300" width="auto" alt="{{ config('app.name') }}" src="{{ asset('graphics/logo/logo-dark.svg') }}">
                            </div>
                            <div class="col-lg-7">
                                <div class="p-5">
                                    <div class="text-left">
                                        <h1 class="h4 text-gray-900 mb-2">{{ __('auth.confirm_password_title') }}</h1>
                                        <p class="mb-4">
                                            {{ __('auth.confirm_password_text') }}
                                        </p>
                                    </div>
                                    <form method="POST" action="{{ route('password.confirm') }}">
                                        @csrf
                                        <div class="form-group">
                                            <x-input-label for="password" :value="__('auth.labels.password')" />

                                            <x-text-input id="password" class="block mt-1 w-full"
                                                          type="password"
                                                          name="password"
                                                          required autocomplete="current-password" />

                                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                        </div>

                                        <div class="flex justify-end mt-4">
                                            <x-primary-button>
                                                {{ __('auth.confirm_password') }}
                                            </x-primary-button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>

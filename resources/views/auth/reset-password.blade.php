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
                            <div class="d-flex justify-content-center align-items-center col-lg-5 d-none px-3 py-5 bg-forgot-password-image">
                                <img height="300" width="auto" alt="{{ config('app.name') }}" src="{{ asset('storage/images/cross.svg') }}">
                            </div>
                            <div class="col-lg-7">
                                <div class="p-5">
                                    <div class="text-left">
                                        <h1 class="h4 text-gray-900 mb-2">{{ __('auth.forgot_password_title') }}</h1>
                                        <p class="mb-4">
                                            {{ __('auth.confirm_password_text') }}
                                        </p>
                                    </div>
                                    <form method="POST" action="{{ route('password.store') }}">
                                        @csrf

                                        <!-- Password Reset Token -->
                                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                                        {{-- Email --}}
                                        <div class="form-group">
                                            <x-input-label for="email" :value="__('auth.labels.email')" />
                                            <x-text-input id="email"
                                                          class="block mt-1 w-full"
                                                          type="email"
                                                          name="email"
                                                          placeholder="{{ __('auth.placeholders.email') }}"
                                                          :value="old('email', $request->email)"
                                                          required autofocus autocomplete="username" />
                                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                        </div>

                                        <!-- Password -->
                                        <div class="mt-4">
                                            <x-input-label for="password" :value="__('auth.labels.password')" />
                                            <x-text-input id="password"
                                                          class="block mt-1 w-full"
                                                          type="password"
                                                          name="password"
                                                          placeholder="{{ __('auth.placeholders.password') }}"
                                                          required autocomplete="new-password" />
                                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                        </div>

                                        <div class="form-group mt-4">
                                            <x-input-label for="password_confirmation" :value="__('auth.labels.confirm_password')" />

                                            <x-text-input id="password_confirmation"
                                                          class="block mt-1 w-full"
                                                          type="password"
                                                          placeholder="{{ __('auth.placeholders.confirm_password') }}"
                                                          name="password_confirmation" required autocomplete="new-password" />

                                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                        </div>

                                        <div class="flex justify-end mt-4">
                                            <x-primary-button>
                                                {{ __('auth.confirm') }}
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

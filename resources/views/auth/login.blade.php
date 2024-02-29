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
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">{{ config('app.name') }}</h1>
                                    </div>
                                    <form>
                                        <div class="form-group">
                                            <x-text-input
                                                id="email"
                                                aria-describedby="email"
                                                class="form-control"
                                                type="email"
                                                name="email"
                                                :value="old('email')"
                                                required autofocus autocomplete="email"
                                                placeholder="{{ __('auth.placeholders.email') }}"/>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control"
                                                   id="exampleInputPassword" placeholder="{{ __('auth.placeholders.password') }}">
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">
                                                    {{ __('auth.labels.remember_me') }}
                                                </label>
                                            </div>
                                        </div>
                                        <a href="#" class="btn btn-primary btn-user btn-block">
                                            {{ __('auth.log_in') }}
                                        </a>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="#">{{ __('auth.labels.forgot_password') }}</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="#">{{ __('auth.create_account') }}</a>
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

<x-guest-layout>

    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div
                                class="d-flex justify-content-center align-items-center col-lg-5 d-none px-3 py-5 bg-verify-email-image">
                                <img height="100" width="auto" alt="{{ config('app.name') }}"
                                     src="{{ asset('graphics/logo/logo-dark.svg') }}">
                            </div>
                            <div class="col-lg-7">
                                <div class="p-5">
                                    <div class="text-left">
                                        <h1 class="h4 text-gray-900 mb-4">{{ __('auth.new_verification_link_title') }}</h1>
                                        <p class="text-gray-900 mb-4">{{ __('auth.new_verification_link_text') }}</p>

                                        @if (session('status') === 'verification-link-sent')
                                            <p class="mb-4">
                                                {{ __('auth.new_verification_link_text') }}
                                            </p>
                                        @endif
                                    </div>
                                    <form method="POST" action="{{ route('verification.send') }}">
                                        @csrf
                                        <x-primary-button>
                                            {{ __('auth.resend_verification_email') }}
                                        </x-primary-button>
                                    </form>
                                    <hr>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <x-primary-button>
                                            {{ __('auth.log_out') }}
                                        </x-primary-button>
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

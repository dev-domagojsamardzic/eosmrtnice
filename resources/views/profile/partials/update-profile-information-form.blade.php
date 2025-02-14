<section>
    <header class="row">
        <div class="col-12">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('profile.basic_information') }}
            </h2>
        </div>

        <div class="col-12">
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('profile.basic_information_subtitle') }}
            </p>
        </div>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route(auth_user_type() . '.profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div class="form-group row">
            <div class="col-md-6 col-sm-12 col-xs-12">
                <x-input-label for="first_name" :value="__('admin.labels.first_name')"/>
                <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full"
                              :value="old('first_name', $user->first_name)" required autofocus
                              autocomplete="first_name"/>
                <x-input-error class="mt-2" :messages="$errors->get('first_name')"/>
            </div>
            <div class="col-md-6 col-sm-12 col-xs-12">
                <x-input-label for="last_name" :value="__('admin.labels.last_name')"/>
                <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full"
                              :value="old('last_name', $user->last_name)" required autocomplete="last_name"/>
                <x-input-error class="mt-2" :messages="$errors->get('last_name')"/>
            </div>

            <div class="col-sm-12 mt-4">
                <x-input-label class="d-block" for="gender" :value="__('admin.labels.gender')"/>
                <x-input-radio-inline name="gender" :options="$genders" :selected="$user->gender"></x-input-radio-inline>
            </div>
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" :required_tag="true"/>
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                          :value="old('email', $user->email)" required autocomplete="email"/>
            <x-input-error class="mt-2" :messages="$errors->get('email')"/>

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('auth.your_email_is_unverified') }}

                        <button form="send-verification"
                                class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('auth.click_here_to_resend_verification_email') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('auth.new_verification_link_sent') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('common.save') }}</x-primary-button>

            {{--@if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('common.saved') }}</p>
            @endif--}}
        </div>
    </form>
</section>

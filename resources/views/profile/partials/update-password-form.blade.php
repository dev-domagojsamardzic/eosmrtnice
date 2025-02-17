<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('profile.update_password_title') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('profile.update_password_subtitle') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div class="form-group row">
            <div class="col-12">
                <x-input-label for="update_password_current_password" :value="__('profile.current_password')" />
                <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full"/>
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
            </div>
        </div>

        <div class="form-group row">
            <div class="col-12">
                <x-input-label for="update_password_password" :value="__('profile.new_password')" />
                <x-input-info :content="__('auth.password_rules')" />
                <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full"/>
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
            </div>
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('profile.confirm_new_password')" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full"/>
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('common.save') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('common.updated') }}</p>
            @endif
        </div>
    </form>
</section>

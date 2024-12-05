{{-- Form section --}}
<section>
    <header class="row">
        <div class="col-12">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('profile.payment_info') }}
            </h2>
        </div>

        <div class="col-12">
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('profile.payment_info_subtitle') }}
            </p>
        </div>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route(auth_user_type() . '.profile.payment-info.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div class="form-group row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <x-input-label for="address" :value="__('admin.labels.address')"/>
                <x-input-info style="display:inline-block;" :content="__('models/company.address_info')"/>
                <x-text-input id="address" name="address" type="text" class="mt-1 block w-full"
                              :value="old('address', $user->address)" autofocus/>
                <x-input-error class="mt-2" :messages="$errors->get('address')"/>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-4 col-sm-12 col-xs-12">
                <x-input-label for="zipcode" :value="__('admin.labels.zipcode')"/>
                <x-text-input id="zipcode" name="zipcode" type="text" class="mt-1 block w-full"
                              :value="old('zipcode', $user->zipcode)"/>
                <x-input-error class="mt-2" :messages="$errors->get('zipcode')"/>
            </div>
            <div class="col-md-8 col-sm-12 col-xs-12">
                <x-input-label for="town" :value="__('admin.labels.town')"/>
                <x-text-input id="town" name="town" type="text" class="mt-1 block w-full"
                              :value="old('town', $user->town)"/>
                <x-input-error class="mt-2" :messages="$errors->get('town')"/>
            </div>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('common.save') }}</x-primary-button>
        </div>
    </form>
</section>

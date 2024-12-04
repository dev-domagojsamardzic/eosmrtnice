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
</section>

{{-- Info section --}}
<section class="mt-3">
    <header class="row">
        <div class="col-12">
            <div @class(["alert", 'alert-success' => $user->isPdf417DataComplete(), 'alert-danger' => !$user->isPdf417DataComplete()]) role="alert">
                {{ $user->isPdf417DataComplete() ? __('admin.data_complete_info') : __('admin.data_missing_info') }}
            </div>
        </div>
    </header>
    <p>
        <span style="display: inline-block; width: 60%">{{ __('admin.full_name') }}</span>
        <small @class(['font-bold', 'text-success' => model_attribute_valid($user, 'first_name') && model_attribute_valid($user, 'last_name'), 'text-danger' => !model_attribute_valid($user, 'first_name') || !model_attribute_valid($user, 'last_name')])>
            {{ model_attribute_valid($user, 'first_name') && model_attribute_valid($user, 'last_name') ? __('common.entered') : __('common.missing') }}
        </small>
    </p>
    <p>
        <span style="display: inline-block; width: 60%">{{ __('admin.address') }}</span>
        <small @class(['font-bold', 'text-success' => model_attribute_valid($user, 'address'), 'text-danger' => !model_attribute_valid($user, 'address')])>
            {{ model_attribute_valid($user, 'address') ? __('common.entered') : __('common.missing') }}
        </small>
    </p>
    <p>
        <span style="display: inline-block; width: 60%;">{{ __('admin.labels.zipcode') }}</span>
        <small @class(['font-bold', 'text-success' => model_attribute_valid($user, 'zipcode'), 'text-danger' => !model_attribute_valid($user, 'zipcode')])>
            {{ model_attribute_valid($user, 'zipcode') ? __('common.entered') : __('common.missing') }}
        </small>
    </p>
    <p>
        <span style="display: inline-block; width: 60%;">{{ __('admin.labels.town') }}</span>
        <small @class(['font-bold', 'text-success' => model_attribute_valid($user, 'town'), 'text-danger' => !model_attribute_valid($user, 'town')])>
            {{ model_attribute_valid($user, 'town') ? __('common.entered') : __('common.missing') }}
        </small>
    </p>
</section>
{{-- Form section --}}
<section>
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

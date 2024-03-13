<x-app-layout>
    <x-slot name="header">
        <h2 class="font-weight-bolder mb-4">
            {{ __('admin.users') }} - {{ __("common.{$action_name}") }}
        </h2>
    </x-slot>

    <div>
        <form method="POST" action="{{ $action }}">
            @csrf
            {{ method_field('PUT') }}
            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <x-input-label for="first_name" :value="__('auth.labels.first_name')" />
                    <x-text-input
                        id="first_name"
                        type="text"
                        name="first_name"
                        :value="old('first_name', $user->first_name)"
                        placeholder="{{ __('auth.placeholders.first_name') }}"/>
                </div>
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <x-input-label for="last_name" :value="__('auth.labels.last_name')" />
                    <x-text-input
                        id="last_name"
                        type="text"
                        name="last_name"
                        :value="old('last_name', $user->last_name)"
                        placeholder="{{ __('auth.placeholders.last_name') }}"/>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-12 mb-3 mb-sm-0">
                    <x-input-label class="d-block" for="sex" :value="__('auth.labels.sex')" />
                    @php
                        $options = \App\Enums\UserSex::options();
                    @endphp
                    <x-input-radio-inline name="sex" :options="$options" :selected="$user->sex"></x-input-radio-inline>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-12">
                    <x-input-label for="email" :value="__('auth.labels.email')" />
                    <x-text-input
                        id="email"
                        type="email"
                        name="email"
                        :value="old('email', $user->email)"
                        placeholder="{{ __('auth.placeholders.email') }}"/>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
            </div>
            <div class="form-group row mt-2">
                <div class="col-2">
                    <div class="custom-control custom-switch">
                        <input name="active" type="checkbox" class="custom-control-input" id="activeSwitch" {{ $user->active ? "checked" : "" }}>
                        <label class="custom-control-label" for="activeSwitch">{{ __('common.active') }}</label>
                    </div>
                </div>
            </div>

            <div class="form-group row mt-5">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary btn-user">
                        {{ __('common.save') }}
                    </button>
                    <a class="btn btn-link btn-user ml-5" href="{{ url()->previous() }}">
                        {{ __('common.quit') }}
                    </a>
                </div>
            </div>
        </form>
    </div>

</x-app-layout>

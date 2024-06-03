<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-gray-800 mb-4 dark:text-gray-200">
            {{ __('admin.partners') }} - {{ $partner->full_name }}
        </h2>
    </x-slot>

    <div>
        <div class="form-group row">
            <div class="col-sm-6 mb-3 mb-sm-0">
                <x-input-label for="first_name" :value="__('auth.labels.first_name')" />
                <x-text-input
                    disabled="true"
                    :value="$partner->first_name"/>
            </div>
            <div class="col-sm-6 mb-3 mb-sm-0">
                <x-input-label for="last_name" :value="__('auth.labels.last_name')" />
                <x-text-input
                    disabled="true"
                    :value="$partner->last_name"/>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-12 mb-3 mb-sm-0">
                <p><b>{{ __('admin.gender') }}</b>: {{ strtoupper($partner->gender) }}</p>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-12">
                <x-input-label for="email" :value="__('auth.labels.email')" />
                <x-text-input
                    disabled="true"
                    :value="$partner->email"/>
            </div>
        </div>
        <div class="form-group row mt-2">
            <div class="col-2">
                <p><b>{{ __('common.active') }}</b>: {{ $partner->active ? __('common.yes') : __('common.no') }}</p>
            </div>
        </div>

        <div class="form-group row mt-5">
            <a class="btn btn-primary btn-user" href="{{ route('admin.partners.edit', ['partner' => $partner]) }}">
                {{ __('common.quit') }}
            </a>
        </div>
    </div>

</x-app-layout>

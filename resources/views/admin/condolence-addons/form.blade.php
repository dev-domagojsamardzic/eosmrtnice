<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-gray-800 mb-4 dark:text-gray-200">
            {{ __('admin.condolence_addons') }} - {{ __("common.{$action_name}") }}
        </h2>
    </x-slot>

    <div>
        <form method="POST" action="{{ $action }}">
            @csrf
            @if($addon->exists)
                {{ method_field('PUT') }}
            @endif

            {{-- title --}}
            <div class="form-group row">
                <div class="col-md-9 col-sm-12">
                    <x-input-label for="title" :value="__('models/condolence_addons.title')" :required_tag="true"/>
                    <x-text-input
                        id="title"
                        name="title"
                        type="text"
                        :value="old('title', $addon->title)"/>
                    <x-input-error :messages="$errors->get('title')" class="mt-2"/>
                </div>

                <div class="col-md-3 col-sm-12">
                    <x-input-label for="price" :value="__('models/condolence_addons.price')" :required_tag="true"/>
                    <div class="input-group input-group-joined">
                        <input name="price"
                               id="price"
                               type="number"
                               min="0.00"
                               step="0.01"
                               class="form-control"
                               value="{{ old('price', $addon->price) }}">
                        <span class="input-group-text">
                            <b>{{ config('app.currency_symbol') }}</b>
                        </span>
                    </div>
                </div>
            </div>

            <div class="form-group row mt-5">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary btn-user">
                        {{ __('common.save') }}
                    </button>
                    <a class="btn btn-link btn-user ml-5" href="{{ $quit }}">
                        {{ __('common.quit') }}
                    </a>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>

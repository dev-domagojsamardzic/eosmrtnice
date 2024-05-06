<x-app-layout>
    <x-slot name="header">
        <h2 class="font-weight-bolder mb-4">
            {{ __('admin.companies') }} - {{ __("common.{$action_name}") }}
        </h2>
    </x-slot>

    <div>
        <form method="POST" action="{{ $action }}">
            @csrf
            {{ method_field('PUT') }}

            {{-- Logo --}}
            <div class="form-group row">
                <div class="col-lg-6 col-md-12 mb-3">
                    <x-input-label for="logo" :value="__('models/company.logo')"></x-input-label>
                    <x-input-info :content="__('models/company.logo_helper_info')" />
                    <input type="file" name="logo" id="logo">
                    <small id="logo-message" class="text-xs font-weight-bold"></small>
                </div>
            </div>

            {{-- website --}}
            <div class="form-group row">
                <div class="col-lg-6 col-md-12 mb-3">
                    <x-input-label for="website" :value="__('models/company.website')"></x-input-label>
                    <x-text-input
                        id="website"
                        name="website"
                        type="text"
                        :value="old('website', $company->website)"
                        placeholder="{{ __('models/company.placeholders.website') }}"/>
                    <x-input-error :messages="$errors->get('website')" class="mt-2" />
                </div>
            </div>

            <div class="form-group row">
                {{-- type --}}
                <div class="col-lg-6 col-sm-12 mb-3">
                    <x-input-label for="type" :value="__('admin.labels.company_type')" :required_tag="true"/>
                    <select class="form-control border border-dark" name="type" id="type">
                        @foreach($types as $value => $type)
                            @if((int)old('type') === $value)
                                <option value="{{ $value }}" selected>{{ $type }}</option>
                            @elseif($company->type === $value)
                                <option value="{{ $value }}" selected>{{ $type }}</option>
                            @else
                                <option value="{{ $value }}">{{ $type }}</option>
                            @endif
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('type')" class="mt-2" />
                </div>
            </div>

            <div class="form-group row">
                {{-- title --}}
                <div class="col-lg-6 mb-3">
                    <x-input-label for="title" :value="__('admin.labels.company_title')" :required_tag="true"/>
                    <x-text-input
                        id="title"
                        type="text"
                        name="title"
                        :value="old('title', $company->title)"
                        required
                        placeholder="{{ __('admin.placeholders.company_title') }}"/>
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>
            </div>

            <div class="form-group row">
                {{-- county_id --}}
                <div class="col-md-6 mb-3">
                    <x-input-label for="county_id" :value="__('auth.labels.company_county')" :required_tag="true"/>
                    <select class="form-control border border-dark" id="county_id" name="county_id">
                        @foreach($counties as $county)
                            @if((int) old('county_id', $company->county_id) === $county->id)
                                <option value="{{ $county->id }}" selected>{{ $county->title }}</option>
                            @else
                                <option value="{{ $county->id }}">{{ $county->title }}</option>
                            @endif
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('county_id')" class="mt-2"/>
                </div>

                {{-- city_id --}}
                <div class="col-md-6 mb-3">
                    <x-input-label for="city_id" :value="__('auth.labels.company_city')" :required_tag="true"/>
                    <select class="form-control border border-dark" id="city_id" name="city_id">
                        @foreach($cities as $city)
                            @if((int) old('city_id', $company->city_id) === $city->id)
                                <option value="{{ $city->id }}" selected>{{ $city->title }}</option>
                            @else
                                <option value="{{ $city->id }}">{{ $city->title }}</option>
                            @endif
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('city_id')" class="mt-2"/>
                </div>

                {{-- address --}}
                <div class="col-sm-12 mb-2">
                    <x-input-label for="address" :value="__('admin.labels.company_address')" />
                    <x-text-input
                        id="address"
                        type="text"
                        name="address"
                        :value="old('address', $company->address)"
                        placeholder="{{ __('admin.placeholders.company_address') }}"/>
                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                </div>
                {{-- town --}}
                <div class="col-md-8 mb-2">
                    <x-input-label for="town" :value="__('admin.labels.company_town')" />
                    <x-text-input
                        id="town"
                        type="text"
                        name="town"
                        :value="old('town', $company->town)"
                        placeholder="{{ __('admin.placeholders.company_town') }}"/>
                    <x-input-error :messages="$errors->get('town')" class="mt-2" />
                </div>
                {{-- zipcode --}}
                <div class="col-md-4 mb-2">
                    <x-input-label for="zipcode" :value="__('admin.labels.company_zipcode')" />
                    <x-text-input
                        id="zipcode"
                        type="text"
                        name="zipcode"
                        maxlength="5"
                        :value="old('zipcode', $company->zipcode)"
                        placeholder="{{ __('admin.placeholders.company_zipcode') }}"/>
                    <x-input-error :messages="$errors->get('zipcode')" class="mt-2" />
                </div>
            </div>

            <div class="form-group row">

                <div class="col-md-6 mb-2">
                    <x-input-label for="oib" :value="__('admin.oib')" :required_tag="true"/>
                    <x-text-input
                        id="oib"
                        type="text"
                        name="oib"
                        :value="old('oib', $company->oib)"
                        required
                        maxlength="11"
                        placeholder="{{ __('admin.placeholders.company_oib') }}"/>
                    <x-input-error :messages="$errors->get('oib')" class="mt-2" />
                </div>

                <div class="col-md-6 mb-2">
                    <x-input-label for="email" :value="__('admin.labels.company_email')" />
                    <x-text-input
                        id="email"
                        type="email"
                        name="email"
                        :value="old('email', $company->email)"
                        placeholder="{{ __('admin.placeholders.company_email') }}"/>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="col-md-6 col-sm-12 my-2">
                    <x-input-label for="phone" :value="__('admin.labels.company_phone')" />
                    <x-text-input
                        id="phone"
                        type="text"
                        name="phone"
                        :value="old('phone', $company->phone)"
                        placeholder="{{ __('admin.placeholders.company_phone') }}"/>
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>

                <div class="col-md-6 col-sm-12 my-2">
                    <x-input-label for="mobile_phone" :value="__('admin.labels.company_mobile_phone')" />
                    <x-text-input
                        id="mobile_phone"
                        type="text"
                        name="mobile_phone"
                        :value="old('mobile_phone', $company->mobile_phone)"
                        placeholder="{{ __('admin.placeholders.company_mobile_phone') }}"/>
                    <x-input-error :messages="$errors->get('mobile_phone')" class="mt-2" />
                </div>
            </div>

            <div class="form-group row">
                <div class="col-2 my-2">
                    <div class="custom-control custom-switch">
                        <input name="active" type="checkbox" class="custom-control-input" id="activeSwitch" {{ $company->active ? "checked" : "" }}>
                        <label class="custom-control-label" for="activeSwitch">{{ __('common.is_active_f') }}</label>
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
    @push('scripts')
        <script type="module">
            document.addEventListener('DOMContentLoaded', function() {

                const pond = FilePond.create(document.querySelector('#logo'), {
                    labelIdle: '{!! __('filepond.labelIdle') !!}',
                    labelInvalidField: '{{ __('filepond.labelInvalidField') }}',
                    labelFileWaitingForSize: '{{ __('filepond.labelFileWaitingForSize') }}',
                    labelFileSizeNotAvailable: '{{ __('filepond.labelFileSizeNotAvailable') }}',
                    labelFileLoading: '{{ __('filepond.labelFileLoading') }}',
                    labelFileLoadError: '{{ __('filepond.labelFileLoadError') }}',
                    labelFileProcessing: '{{ __('filepond.labelFileProcessing') }}',
                    labelFileProcessingComplete: '{{ __('filepond.labelFileProcessingComplete') }}',
                    labelFileProcessingAborted: '{{ __('filepond.labelFileProcessingAborted') }}',
                    labelFileProcessingError: '{{ __('filepond.labelFileProcessingError') }}',
                    labelFileProcessingRevertError: '{{ __('filepond.labelFileProcessingRevertError') }}',
                    labelFileRemoveError: '{{ __('filepond.labelFileRemoveError') }}',
                    labelTapToCancel: '{{ __('filepond.labelTapToCancel') }}',
                    labelTapToRetry: '{{ __('filepond.labelTapToRetry') }}',
                    labelTapToUndo: '{{ __('filepond.labelTapToUndo') }}',
                    labelButtonRemoveItem: '{{ __('filepond.labelButtonRemoveItem') }}',
                    labelButtonAbortItemLoad: '{{ __('filepond.labelButtonAbortItemLoad') }}',
                    labelButtonRetryItemLoad: '{{ __('filepond.labelButtonRetryItemLoad') }}',
                    labelButtonAbortItemProcessing: '{{ __('filepond.labelButtonAbortItemProcessing') }}',
                    labelButtonUndoItemProcessing: '{{ __('filepond.labelButtonUndoItemProcessing') }}',
                    labelButtonRetryItemProcessing: '{{ __('filepond.labelButtonRetryItemProcessing') }}',
                    labelButtonProcessItem: '{{ __('filepond.labelButtonProcessItem') }}',
                    imageValidateSizeMinWidth: 100,
                    imageValidateSizeMaxWidth: 1200,
                    imageValidateSizeMinHeight: 50,
                    imageValidateSizeMaxHeight: 900,
                    imageValidateSizeLabelFormatError: '{{ __('filepond.imageValidateSizeLabelFormatError') }}',
                    imageValidateSizeLabelImageSizeTooSmall: '{{ __('filepond.imageValidateSizeLabelImageSizeTooSmall') }}',
                    imageValidateSizeLabelImageSizeTooBig: '{{ __('filepond.imageValidateSizeLabelImageSizeTooBig') }}',
                    imageValidateSizeLabelExpectedMinSize: '{{ __('filepond.imageValidateSizeLabelExpectedMinSize') }}',
                    imageValidateSizeLabelExpectedMaxSize: '{{ __('filepond.imageValidateSizeLabelExpectedMaxSize') }}',
                    allowPaste: false,
                    checkValidity: true,
                    credits: null,
                    dropValidation: true,
                    acceptedFileTypes: ['image/jpeg', 'image/png', 'image/svg+xml', 'image/webp'],
                    files: [
                        @if($company->logo)
                        {
                            source: '{{ Storage::disk('public')->url('images/partners/logo/' . $company->logo) }}',
                            options: {
                                type: 'local',
                            },
                        }
                        @endif
                    ],
                    server: {
                        load: (source, load) => {
                            fetch(source)
                                .then(res => res.blob())
                                .then(load);
                        },
                        revert: '{{ route('images.upload.revert') }}',
                        process: {
                            url: '{{ route('images.upload') }}',
                            method: 'POST',
                            onload: (response) => {
                                response = JSON.parse(response);
                                return response.image;
                            },
                            onerror: (response) => {
                                response = JSON.parse(response);
                                $('#logo-message').removeClass(['text-success','text-danger'])
                                    .text('')
                                    .addClass(response.class)
                                    .text(response.message);
                                return response;
                            }
                        },
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                    },
                });
            })
        </script>
    @endpush
</x-app-layout>

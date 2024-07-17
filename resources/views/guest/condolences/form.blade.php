<x-guest-layout>
    <h1 class="my-5">{{ __('models/condolence.send_condolence') }}</h1>
    <p>{{ __('models/condolence.condolences_intro') }}</p>
    <p>{{ __('models/condolence.condolences_contact') }} <span class="font-weight-bold h4">{{ config('eosmrtnice.company.phone') }}</span></p>

    {{-- motive --}}
    <div class="form-group row mt-5">
        <div class="col-12">
            <h6>{{ __('models/condolence.motive') }}</h6>
            <p>{{ __('models/condolence.motive_info') }}</p>
            <div class="img-select-component w-100 mt-4">
                <div class="row">
                    <div class='col text-center'>
                        <input type="radio" name="motive" id="img1" class="d-none imgbgchk" value="">
                        <label for="img1">
                            <img src="https://dummyimage.com/600x400/000/fff" alt="Image 1">
                            <div class="tick_container">
                                <div class="tick"><i class="fa fa-check"></i></div>
                            </div>
                        </label>
                    </div>
                    <div class='col text-center'>
                        <input type="radio" name="motive" id="img2" class="d-none imgbgchk" value="">
                        <label for="img2">
                            <img src="https://dummyimage.com/600x400/000/fff" alt="Image 2">
                            <div class="tick_container">
                                <div class="tick"><i class="fa fa-check"></i></div>
                            </div>
                        </label>
                    </div>
                    <div class='col text-center'>
                        <input type="radio" name="motive" id="img3" class="d-none imgbgchk" value="">
                        <label for="img3">
                            <img src="https://dummyimage.com/600x400/000/fff" alt="Image 3">
                            <div class="tick_container">
                                <div class="tick"><i class="fa fa-check"></i></div>
                            </div>
                        </label>
                    </div>
                    <div class='col text-center'>
                        <input type="radio" name="motive" id="img4" class="d-none imgbgchk" value="">
                        <label for="img4">
                            <img src="https://dummyimage.com/600x400/000/fff" alt="Image 4">
                            <div class="tick_container">
                                <div class="tick"><i class="fa fa-check"></i></div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- message --}}
    <div class="form-group row mt-5">
        <div class="col-12">
            <h6>{{ __('models/condolence.message') }}</h6>
            <p class="text-md">{{ __('models/condolence.message_info') }}</p>
            <textarea id="message" name="message" class="form-control" rows="5"></textarea>
            <x-input-error :messages="$errors->get('message')" class="mt-2" />
        </div>
    </div>

    {{-- package_addon --}}
    <div class="form-group row mt-5">
        <div class="col-12">
            <h6>{{ __('models/condolence.package_addon') }}</h6>
            <p>{{ __('models/condolence.package_addon_info') }}</p>
            @foreach($addons as $key => $addon)
                <div class="form-check mt-3">
                    <input class="form-check-input" name="package_addon[]" type="checkbox" value="{{ $key }}" id="packageAddon{{ $key }}">
                    <label class="form-check-label label-lg ml-2 mt-0.5" for="packageAddon{{ $key }}">
                        {{ $addon }}
                    </label>
                </div>
            @endforeach
        </div>
    </div>

    {{-- RECIPIENT DATA --}}
    <h3 class="mt-5">{{ __('models/condolence.recipient_data') }}</h3>
    <p >{{ __('models/condolence.recipient_data_info') }}</p>
    <hr class="hr_gray_500 w-75">

    <div class="form-group row">
        <div class="col-md-6 col-sm-12">
            {{-- Recipient full name --}}
            <div class="form-group row">
                <div class="col-12">
                    <label for="recipient_full_name" class="text-md-left font-weight-bold mb-0">
                        {{ __('models/condolence.recipient_full_name') }}
                    </label>
                    <br>
                    <small class="d-inline-block font-weight-normal">
                        <i class="fas fa-info-circle mr-2"></i>
                        {{ __('models/condolence.recipient_full_name_info') }}
                    </small>
                    <x-text-input id="recipient_full_name"
                                  name="recipient_full_name"
                                  value=""
                                  placeholder="{{ __('models/condolence.recipient_full_name_placeholder') }}"
                    />
                    <x-input-error :messages="$errors->get('recipient_full_name')" class="mt-2" />
                </div>
            </div>

            {{-- Recipient address --}}
            <div class="form-group row">
                <div class="col-12">
                    <label for="recipient_address" class="text-md-left font-weight-bold mb-0">
                        {{ __('models/condolence.recipient_address') }}
                    </label>
                    <br>
                    <small class="d-inline-block font-weight-normal">
                        <i class="fas fa-info-circle mr-2"></i>
                        {{ __('models/condolence.recipient_address_info') }}
                    </small>
                    <textarea id="recipient_address" name="recipient_address" class="form-control" rows="5" placeholder="{{__('models/condolence.recipient_address_placeholder')}}"></textarea>
                    <x-input-error :messages="$errors->get('recipient_address')" class="mt-2" />
                </div>
            </div>
        </div>
    </div>

    {{-- SENDER DATA --}}
    <h3 class="mt-5">{{ __('models/condolence.sender_data') }}</h3>
    <p>{{ __('models/condolence.sender_data_info') }}</p>
    <hr class="hr_gray_500 w-75">

    <div class="form-group row">
        <div class="col-md-6 col-sm-12">
            {{-- sender_full_name --}}
            <div class="form-group row">
                <div class="col-12">
                    <label for="sender_full_name" class="text-md-left font-weight-bold mb-0">
                        {{ __('models/condolence.sender_full_name') }}
                    </label>
                    <br>
                    <small class="d-inline-block font-weight-normal">
                        <i class="fas fa-info-circle mr-2"></i>
                        {{ __('models/condolence.sender_full_name_info') }}
                    </small>
                    <x-text-input id="sender_full_name"
                                  name="sender_full_name"
                                  value="{{ old('sender_full_name') }}"
                                  placeholder="{{ __('models/condolence.sender_full_name_placeholder') }}"
                    />
                    <x-input-error :messages="$errors->get('sender_full_name')" class="mt-2" />
                </div>
            </div>

            {{-- sender_email --}}
            <div class="form-group row">
                <div class="col-12">
                    <label for="sender_email" class="text-md-left font-weight-bold mb-0">
                        {{ __('models/condolence.sender_email') }}
                    </label>
                    <br>
                    <small class="d-inline-block font-weight-normal">
                        <i class="fas fa-info-circle mr-2"></i>
                        {{ __('models/condolence.sender_email_info') }}
                    </small>

                    <x-text-input id="sender_email"
                                  name="sender_email"
                                  value="{{ old('sender_email') }}"
                                  placeholder="{{ __('models/condolence.sender_email_placeholder') }}"
                    />
                    <x-input-error :messages="$errors->get('sender_email')" class="mt-2" />
                </div>
            </div>

            {{-- sender_phone --}}
            <div class="form-group row">
                <div class="col-12">
                    <label for="sender_phone" class="text-md-left font-weight-bold mb-0">
                        {{ __('models/condolence.sender_phone') }}
                    </label>
                    <br>
                    <small class="d-inline-block font-weight-normal">
                        <i class="fas fa-info-circle mr-2"></i>
                        {{ __('models/condolence.sender_phone_info') }}
                    </small>

                    <x-text-input id="sender_phone"
                                  name="sender_phone"
                                  value="{{ old('sender_phone') }}"
                                  placeholder="{{ __('models/condolence.sender_phone_placeholder') }}"
                    />
                    <x-input-error :messages="$errors->get('sender_phone')" class="mt-2" />
                </div>
            </div>
        </div>

        <div class="col-md-6 col-sm-12">
            {{-- sender_address --}}
            <div class="form-group col-12">
                <label for="sender_address" class="text-md-left font-weight-bold mb-0">
                    {{ __('models/condolence.sender_address') }}
                </label>
                <br>
                <small class="d-inline-block font-weight-normal">
                    <i class="fas fa-info-circle mr-2"></i>
                    {{ __('models/condolence.sender_address_info') }}
                </small>
                <textarea id="sender_address" name="sender_address" class="form-control" rows="5"></textarea>
                <x-input-error :messages="$errors->get('sender_address')" class="mt-2" />
            </div>
            {{-- Sender additiona info --}}
            <div class="form-group col-12">
                <label for="sender_additional_info" class="text-md-left font-weight-bold mb-0">
                    {{ __('models/condolence.sender_additional_info') }}
                </label>
                <br>
                <small class="d-inline-block font-weight-normal"><i class="fas fa-info-circle mr-2"></i>{{ __('models/condolence.sender_additional_info_info') }}</small>
                <textarea id="message" name="message" class="form-control" rows="5" placeholder="{{ __('models/condolence.sender_additional_info_placeholder') }}"></textarea>
                <x-input-error :messages="$errors->get('sender_additional_info')" class="mt-2" />
            </div>
        </div>
    </div>

    <div class="form-group row my-5">
        <div class="col-12">
            <button type="submit" class="btn btn-primary btn-user">
                {{ __('common.send_order') }}
            </button>
        </div>
    </div>
</x-guest-layout>

<x-guest-layout>
    <h1 class="my-5">{{ __('models/condolence.send_condolence') }}</h1>
    <p>{{ __('models/condolence.condolences_intro') }}</p>
    <p>{{ __('models/condolence.condolences_contact') }} <span class="font-weight-bold h4">{{ config('eosmrtnice.company.phone') }}</span></p>

    <form method="POST" action="{{ route('guest.condolences.store') }}">
        {{ csrf_field() }}


        {{-- motive --}}
        <div class="form-group row mt-5">
            <div class="col-12">
                <h6>{{ __('models/condolence.motive') }}</h6>
                <p>{{ __('models/condolence.motive_info') }}</p>
                <p>{!! __('models/condolence.motive_price_info') !!}</p>
                <div class="img-select-component w-100 mt-4">
                    <div class="row">
                        @foreach($motives as $key => $value)
                            <div class="col-sm-12 col-md-3 col-lg-3 text-center">
                                <input type="radio" name="motive" id="motive{{$key}}" class="d-none imgbgchk" value="{{ $value }}" @checked((old('motive')) ? old('motive') == $value : $loop->iteration === 1)>
                                <label for="motive{{$key}}">
                                    <img src="{{ asset('images/motives/' . $key . '.jpg') }}" alt="{{ $value }}">
                                    <div class="tick_container">
                                        <div class="tick"><i class="fa fa-check"></i></div>
                                    </div>
                                </label>
                                <p>{{ $value }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- message --}}
        <div class="form-group row mt-5">
            <div class="col-12">
                <h6>{{ __('models/condolence.message') }}</h6>
                <p class="text-md">{{ __('models/condolence.message_info') }}</p>
                <textarea id="message" name="message" class="form-control" rows="5" placeholder="{{ __('models/condolence.message_placeholder') }}">{{ old('message') }}</textarea>
                <x-input-error :messages="$errors->get('message')" class="mt-2" />
            </div>
        </div>

        {{-- package_addon --}}
        <div class="form-group row mt-5">
            <div class="col-12">
                <h6>{{ __('models/condolence.package_addon') }}</h6>
                <p>{{ __('models/condolence.package_addon_info') }}</p>
                @foreach($addons as $addon)
                    <div class="form-check mt-3">
                        <input class="form-check-input" data-price="{{ $addon['price'] }}" name="package_addon[]" type="checkbox" value="{{ $addon['id'] }}" id="packageAddon{{ $addon['id'] }}" @checked(in_array($addon['id'], old('package_addon', [])))>
                        <label class="form-check-label label-lg ml-2 mt-0.5" for="packageAddon{{ $addon['id'] }}">
                            {{ __('enums.'.$addon['name']) }} - <strong>{{ $addon['price'] . config('app.currency_symbol') }}</strong>
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- RECIPIENT DATA --}}
        <h3 class="mt-5">{{ __('models/condolence.recipient_data') }}</h3>
        <p >{{ __('models/condolence.recipient_data_info') }}</p>
        <hr class="hr_gray_500 w-75">

        <div class="row">
            <div class="col-md-6 col-sm-12">
                {{-- Recipient full name --}}
                <div class="form-group col-12">
                    <label for="recipient_full_name" class="text-md-left font-weight-bold mb-0">
                        {{ __('models/condolence.recipient_full_name') }}
                    </label>
                    <br>
                    {{--<small class="d-inline-block font-weight-normal">
                        <i class="fas fa-info-circle mr-2"></i>
                        {{ __('models/condolence.recipient_full_name_info') }}
                    </small>--}}
                    <x-text-input id="recipient_full_name"
                                  name="recipient_full_name"
                                  value="{{ old('recipient_full_name') }}"
                    />
                    <x-input-error :messages="$errors->get('recipient_full_name')" class="mt-2" />
                </div>
            </div>

            <div class="col-md-6 col-sm-12">
                {{-- recipient_address --}}
                <div class="form-group col-12">
                    <label for="recipient_address" class="text-md-left font-weight-bold mb-0">
                        {{ __('models/condolence.recipient_address') }}
                    </label>
                    <br>
                    <small class="d-inline-block font-weight-normal">
                        <i class="fas fa-info-circle mr-2"></i>
                        {{ __('models/condolence.recipient_address_info') }}
                    </small>
                    <input type="text" id="recipient_address" name="recipient_address" class="form-control" value="{{ old('recipient_address') }}">
                    <x-input-error :messages="$errors->get('recipient_address')" class="mt-2" />
                </div>

                {{-- recipient_zipcode --}}
                <div class="form-group col-md-3 col-sm-12">
                    <label for="recipient_zipcode" class="text-md-left font-weight-bold mb-0">
                        {{ __('models/condolence.recipient_zipcode') }}
                    </label>
                    <br>
                    <input type="text" id="recipient_zipcode" name="recipient_zipcode" class="form-control" value="{{ old('recipient_zipcode') }}">
                    <x-input-error :messages="$errors->get('recipient_zipcode')" class="mt-2" />
                </div>

                {{-- recipient_town --}}
                <div class="form-group col-md-9 col-sm-12">
                    <label for="recipient_town" class="text-md-left font-weight-bold mb-0">
                        {{ __('models/condolence.recipient_town') }}
                    </label>
                    <br>
                    <input type="text" id="recipient_town" name="recipient_town" class="form-control" value="{{ old('recipient_town') }}">
                    <x-input-error :messages="$errors->get('recipient_town')" class="mt-2" />
                </div>
            </div>
        </div>

        {{-- CUSTOMER DATA --}}
        <h3 class="mt-5">{{ __('models/condolence.customer_data') }}</h3>
        <p>{{ __('models/condolence.sender_data_info') }}</p>
        <hr class="hr_gray_500 w-75">

        <div class="row">
            <div class="col-md-6 col-sm-12">

                {{-- sender_full_name --}}
                <div class="form-group col-12">
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
                    />
                    <x-input-error :messages="$errors->get('sender_full_name')" class="mt-2" />
                </div>

                {{-- sender_email --}}
                <div class="form-group col-12">
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
                    />
                    <x-input-error :messages="$errors->get('sender_email')" class="mt-2" />
                </div>

                {{-- sender_phone --}}
                <div class="form-group col-12">
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
                    />
                    <x-input-error :messages="$errors->get('sender_phone')" class="mt-2" />
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
                    <input type="text" id="sender_address" name="sender_address" class="form-control" value="{{ old('sender_address') }}">
                    <x-input-error :messages="$errors->get('sender_address')" class="mt-2" />
                </div>

                {{-- sender_zipcode --}}
                <div class="form-group col-md-6 col-sm-12">
                    <label for="sender_zipcode" class="text-md-left font-weight-bold mb-0">
                        {{ __('models/condolence.sender_zipcode') }}
                    </label>
                    <br>
                    <small class="d-inline-block font-weight-normal">
                        <i class="fas fa-info-circle mr-2"></i>
                        {{ __('models/condolence.sender_zipcode_info') }}
                    </small>
                    <input type="text" id="sender_zipcode" name="sender_zipcode" class="form-control" value="{{ old('sender_zipcode') }}">
                    <x-input-error :messages="$errors->get('sender_zipcode')" class="mt-2"/>
                </div>

                {{-- sender_town --}}
                <div class="form-group col-md-9 col-sm-12">
                    <label for="sender_town" class="text-md-left font-weight-bold mb-0">
                        {{ __('models/condolence.sender_town') }}
                    </label>
                    <br>
                    <small class="d-inline-block font-weight-normal">
                        <i class="fas fa-info-circle mr-2"></i>
                        {{ __('models/condolence.sender_town_info') }}
                    </small>
                    <input type="text" id="sender_town" name="sender_town" class="form-control" value="{{ old('sender_town') }}">
                    <x-input-error :messages="$errors->get('sender_town')" class="mt-2" />
                </div>


                {{-- Sender additiona info --}}
                <div class="form-group col-12">
                    <label for="sender_additional_info" class="text-md-left font-weight-bold mb-0">
                        {{ __('models/condolence.sender_additional_info') }}
                    </label>
                    <br>
                    <small class="d-inline-block font-weight-normal">
                        <i class="fas fa-info-circle mr-2"></i>
                        {{ __('models/condolence.sender_additional_info_info') }}
                    </small>
                    <textarea id="sender_additional_info" name="sender_additional_info" class="form-control" rows="5">{{ old('sender_additional_info') }}</textarea>
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
    </form>
</x-guest-layout>

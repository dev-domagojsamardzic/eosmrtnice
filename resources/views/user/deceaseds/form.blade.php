@inject('carbon', 'Illuminate\Support\Carbon')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-gray-800 mb-4 dark:text-gray-200">
            {{ __('models/deceased.deceaseds') }} - {{ __("common.{$action_name}") }}
        </h2>
    </x-slot>

    <div>
        <form method="POST" action="{{ $action }}">
            @csrf
            @if($deceased->exists)
                {{ method_field('PUT') }}
            @endif

            {{-- Image --}}
            <div class="form-group row" id="form-panel-image">
                <div class="col-lg-3 col-md-4 col-sm-12">
                    <x-input-label for="image" :value="__('models/deceased.image')"></x-input-label>
                    <x-input-info :content="__('models/deceased.image_helper_info')" />
                    <input type="file" name="image" id="image">
                    <small id="image-message" class="text-xs font-weight-bold"></small>
                    <x-input-error :messages="$errors->get('image')" class="mt-2" />
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-12 mb-3 mb-sm-0">
                    <x-input-label class="d-block" for="gender" :value="__('models/deceased.gender')"/>
                    <x-input-radio-inline id="gender" name="gender" :options="$genderOptions" :selected="$deceased->gender->value"></x-input-radio-inline>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-12 col-md-4">
                    <x-input-label for="first_name" :value="__('models/deceased.first_name')" :required_tag="true"/>
                    <x-text-input
                        id="first_name"
                        type="text"
                        name="first_name"
                        :value="old('first_name', $deceased->first_name)"
                        placeholder="{{ __('models/deceased.first_name_placeholder') }}"/>
                    <x-input-error :messages="$errors->get('first_name')" class="mt-2"/>
                </div>
                <div class="col-sm-12 col-md-4">
                    <x-input-label for="last_name" :value="__('models/deceased.last_name')" :required_tag="true"/>
                    <x-text-input
                        id="last_name"
                        type="text"
                        name="last_name"
                        :value="old('last_name', $deceased->last_name)"
                        placeholder="{{ __('models/deceased.last_name_placeholder') }}"/>
                    <x-input-error :messages="$errors->get('last_name')" class="mt-2"/>
                </div>
                <div class="col-sm-12 col-md-4">
                    <x-input-label for="maiden_name" :value="__('models/deceased.maiden_name')"/>
                    <x-text-input
                        id="maiden_name"
                        type="text"
                        name="maiden_name"
                        :value="old('maiden_name', $deceased->maiden_name)"
                        placeholder="{{ __('models/deceased.maiden_name_placeholder') }}"/>
                    <x-input-error :messages="$errors->get('maiden_name')" class="mt-2"/>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-3 col-md-4 col-sm-12">
                    <x-input-label for="date_of_birth" :value="__('models/deceased.date_of_birth')" :required_tag="true"></x-input-label>
                    <div class="input-group input-group-joined date">
                        <input name="date_of_birth"
                               id="date_of_birth"
                               type="text"
                               class="form-control"
                               value="{{ $carbon::parse(old('date_of_birth', $deceased->date_of_birth))->format('d.m.Y.') }}">
                        <span class="input-group-text">
                            <i class="fas fa-calendar-alt"></i>
                        </span>
                    </div>
                    <x-input-error :messages="$errors->get('date_of_birth')" class="mt-2"/>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-3 col-md-4 col-sm-12">
                    <x-input-label for="date_of_death" :value="__('models/deceased.date_of_death')" :required_tag="true"></x-input-label>
                    <div class="input-group input-group-joined date">
                        <input name="date_of_death"
                               id="date_of_death"
                               type="text"
                               class="form-control"
                               value="{{ $carbon::parse(old('date_of_death', $deceased->date_of_death ?? now() ))->format('d.m.Y.') }}">
                        <span class="input-group-text">
                            <i class="fas fa-calendar-alt"></i>
                        </span>
                    </div>
                    <x-input-error :messages="$errors->get('date_of_death')" class="mt-2"/>
                </div>

                {{-- company_county_id --}}
                <div class="col-lg-3 col-md-4 col-sm-12">
                    <x-input-label for="county_id" :value="__('models/deceased.county')" :required_tag="true"/>
                    <select class="form-control border border-dark" id="county_id" name="county_id">
                        @foreach($counties as $id => $county)
                            <option value="{{ $id }}" @selected($id === old('county_id', $deceased->death_county_id ))>{{ $county }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('county_id')" class="mt-2"/>
                </div>

                {{-- company_city_id --}}
                <div class="col-lg-3 col-md-4 col-sm-12">
                    <x-input-label for="city_id" :value="__('models/deceased.city')" :required_tag="true"/>
                    <select class="form-control border border-dark" id="city_id" name="city_id">
                        @foreach($cities as $city)
                            <option data-county="{{ $city->county_id }}" value="{{ $city->id }}" @selected($city->id === old('city_id', $deceased->death_city_id))>{{ $city->title }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('city_id')" class="mt-2"/>
                </div>
            </div>

            <div class="form-group row mt-5">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary btn-user">
                        {{ __('common.save') }}
                    </button>
                    <a class="btn btn-link btn-user ml-2" href="{{ $quit }}">
                        {{ __('common.quit') }}
                    </a>
                </div>
            </div>
        </form>
        @include('partials.filepond.image')
        @push('scripts')
            <script type="module">
                $('#date_of_birth').datepicker({
                    dateFormat: "dd.mm.yy.",
                    changeYear: true,
                    autoSize: true,
                    yearRange: "1900:" + new Date().getFullYear()
                });
                $('#date_of_death').datepicker({
                    dateFormat: "dd.mm.yy.",
                    changeYear: true,
                    autoSize: true,
                });
            </script>
        @endpush
    </div>
</x-app-layout>

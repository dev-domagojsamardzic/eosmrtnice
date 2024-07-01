<form id="adSearchForm" method="GET" action="{{ $route ?? '' }}">
    <div class="form-group ads-search">
        <div class="row">
            <div class="col-sm-12 col-md-4">
                <x-input-label for="county" :value="__('guest.county')"/>
                <select class="form-control border border-dark" id="county" name="county">
                    <option value="0" selected>{{ __('guest.all_counties') }}</option>
                    @foreach($counties as $county)
                        <option value="{{ $county->id }}">{{ $county->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-12 col-md-4">
                <x-input-label for="city" :value="__('guest.city')"/>
                <x-text-input
                    id="city"
                    type="text"
                    name="city"/>
            </div>
            <div class="col-sm-12 col-md-3 mt-auto">
                <button name="submit_ad_search" type="submit" class="btn btn-primary">
                    {{ __('common.search') }}
                </button>
            </div>
        </div>
    </div>
</form>


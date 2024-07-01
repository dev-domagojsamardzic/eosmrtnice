<form id="adSearchForm" method="GET" action="{{ $route ?? '' }}">
    <div class="form-group ads-search row">
        <div class="col-sm-12 col-md-4 mb-3">
            <x-input-label for="county" :value="__('guest.county')"/>
            <select class="form-control border border-dark" id="county" name="county">
                <option value="0" selected>{{ __('guest.all_counties') }}</option>
                @foreach($counties as $county)
                    <option value="{{ $county->id }}">{{ $county->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-sm-12 col-md-4 mb-3">
            <x-input-label for="city" :value="__('guest.city')"/>
            <x-text-input
                id="city"
                type="text"
                name="city"/>
        </div>
        <div class="col-sm-12 col-md-3 mt-auto mb-3">
            <button name="submit_ad_search" type="submit" class="btn btn-primary w-100">
                {{ __('common.search') }}
            </button>
        </div>
    </div>
</form>


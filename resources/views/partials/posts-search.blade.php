<div class="ads-search">

    <div class="row">
        <div class="col-12 d-flex align-items-center justify-content-center">
            <blockquote class="blockquote text-center">
                <p class="mb-0">Kad prijatelja nema, a dani idu sporo, govorili smo za se da vraćaju se skoro.</p>
                <footer class="blockquote-footer"><cite title="Autor">Arsen Dedić</cite></footer>
            </blockquote>
        </div>
    </div>

    <form id="postSearchForm" action="{{ route('homepage.search') }}" method="GET">
        <div class="row">
            <div class="col-12 mb-3">
                <div class="flex justify-content-start align-items-center h-100">
                    <h4 class="font-weight-normal mt-4">{{ __('common.search_obituaries') }}</h4>
                </div>
            </div>

            <div class="col-sm-12 col-md-3 mb-3">
                <x-input-label for="name" :value="__('models/post.full_name')"/>
                <x-text-input
                    id="name"
                    type="text"
                    name="name"
                    value="{{ $name ?? '' }}"/>
            </div>

            <div class="col-sm-12 col-md-3 mb-3">
                <x-input-label for="date" :value="__('models/post.starts_at')"></x-input-label>
                <div class="input-group input-group-joined date">
                    <input name="date"
                           id="date"
                           type="text"
                           value="{{ $date ?? '' }}"
                           class="form-control datepicker" autocomplete="off">
                    <span class="input-group-text">
                            <i class="fas fa-calendar-alt"></i>
                        </span>
                </div>
            </div>

            <div class="col-sm-12 col-md-3 mb-3">
                <x-input-label for="county_id" :value="__('auth.labels.company_county')"/>
                <select class="form-control border border-dark" id="county_id" name="county_id">
                    @foreach(get_counties_array() as $countyID => $county)
                        <option value="{{ $countyID }}">{{ $county }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-sm-12 col-md-3 mt-auto mb-3">
                <button id="submitPostSearch" type="submit" class="btn btn-primary">
                    <i class="fas fa-search mr-2"></i>
                    {{ __('common.search') }}
                </button>
                <a type="button" class="btn btn-link" href="{{ route('homepage') }}">
                    <i class="fas fa-times mr-2"></i>
                    {{ __('common.cancel') }}
                </a>
            </div>
        </div>
    </form>
</div>


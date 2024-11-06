<div class="ads-search">

    <div class="row">
        <div class="col-12 d-flex align-items-center justify-content-center">
            <blockquote class="blockquote text-center">
                <p class="mb-0" style="font-size: 1.25rem">Kad prijatelja nema, a dani idu sporo, govorili smo za se da vraćaju se skoro.</p>
                <footer class="blockquote-footer"><cite title="Autor">Arsen Dedić</cite></footer>
            </blockquote>
        </div>
    </div>

    <form id="postSearchForm" action="{{ route('homepage.search') }}" method="GET">
        <div class="row">

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
                           class="form-control datepicker border border-dark" autocomplete="off">
                    <span class="input-group-text border-datepicker-calendar-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </span>
                </div>
            </div>

            @php($countyID = $county ?? 0)
            @if(isset($canSearchByCounty) && $canSearchByCounty)
                <div class="col-sm-12 col-md-3 mb-3">
                    <x-input-label for="county_id" :value="__('guest.county')"/>
                    <select class="form-control border border-dark" id="county_id" name="county_id">
                        @foreach(get_counties_array() as $county)
                            <option value="{{ $county['id'] }}" @selected($county['id'] === $countyID ?? '')>{{ $county['title'] }}</option>
                        @endforeach
                    </select>
                </div>
            @endif

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


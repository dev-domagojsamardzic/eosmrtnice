<x-guest-layout>
    <h1 class="my-3">{{ __('common.search_results') }}</h1>
    <div class="ads-search">
        @if($name)
            <p>{{ __('guest.search_term') }}: {{ $name }}</p>
        @endif
        @if($date)
            <p>{{ __('guest.date') }}: {{ $date }}</p>
        @endif
        @if($search_county)
            <p>{{ __('guest.county') }}: {{ $search_county }}</p>
        @endif
    </div>
    <div class="row posts_wrapper" id="postsWrapper" data-masonry='{ "percentPosition": true, "itemSelector": ".masonry-item", "columnWidth": ".col-md-4" }'>
        @if($posts->isEmpty())
            <div class="col-12 my-5 flex flex-col align-items-center justify-content-center">
                <i class="far fa-address-card text-gray-600" style="font-size: 62px;"></i>
                <span class="text-gray-600 mt-4">{{ __('common.no_results') }}</span>
            </div>
        @endif

        @foreach($posts as $dateString => $dateCollection)
            @include('partials/posts-masonry-block', ['date' => $dateString, 'collection' => $dateCollection])
        @endforeach
    </div>
</x-guest-layout>

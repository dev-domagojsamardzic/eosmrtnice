<x-guest-layout>
    <div class="posts_wrapper">
        @if($posts->isEmpty())
            <div class="my-5 flex flex-col align-items-center justify-content-center">
                <i class="far fa-address-card text-gray-600" style="font-size: 62px;"></i>
                <span class="text-gray-600 mt-4">{{ __('models/post.no_posts_yet') }}</span>
            </div>
        @endif

        @foreach($posts as $dateString => $dateCollection)
            <div class="posts_date_title w-100 text-center"><h1 class="font-weight-normal line-through">{{ $dateString }}</h1></div>
            <div class="masonry row posts_chunk_wrapper" data-masonry='{"percentPosition": true}'>
                @foreach($dateCollection as $post)
                    <div class="post_wrapper col-sm-12 col-md-4">
                        @include('partials/post',['post' => $post])
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
    @if($nextDateToLoad)
        <div class="w-100 d-flex align-items-center justify-content-center py-5">
            <button type="button" id="loadMorePosts" class="btn btn-primary" data-date="{{ $nextDateToLoad }}">{{ 'Učitaj još' }}</button>
        </div>
    @endif
</x-guest-layout>

<x-guest-layout>
    <div class="posts_wrapper">
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
</x-guest-layout>

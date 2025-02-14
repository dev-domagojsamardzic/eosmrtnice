<div class="masonry-item posts_date_title col-sm-12 text-center">
    <h1 class="font-weight-normal line-through">{{ $date }}</h1>
</div>

@foreach($collection as $item)
    <a target="_blank" href="{{ route('posts.show', ['post' => $item->id, 'slug' => $item->slug]) }}">
        <div class="masonry-item post_wrapper col-sm-12 col-md-4">
            @include('partials/post-card-minimized', ['post' => $item])
        </div>
    </a>
@endforeach

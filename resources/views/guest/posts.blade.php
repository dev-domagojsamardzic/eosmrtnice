<x-guest-layout>
    @isset($pageTitle)
        <h1 class="my-5">{{ $pageTitle }}</h1>
    @endisset

    @include('partials/posts-search')

    <div class="row posts_wrapper" id="postsWrapper" data-masonry='{ "percentPosition": true, "itemSelector": ".masonry-item", "columnWidth": ".col-md-4" }'>
        @if($posts->isEmpty())
            <div class="col-12 my-5 flex flex-col align-items-center justify-content-center">
                <i class="far fa-address-card text-gray-600" style="font-size: 62px;"></i>
                <span class="text-gray-600 mt-4">{{ __('models/post.no_posts_yet') }}</span>
            </div>
        @endif

        @foreach($posts as $dateString => $dateCollection)
            @include('partials/posts-masonry-block', ['date' => $dateString, 'collection' => $dateCollection])
        @endforeach
    </div>
    @if($nextDateToLoad)
        <div class="w-100 d-flex align-items-center justify-content-center py-5">
            <button type="button" id="loadMorePosts" class="btn btn-primary" data-date="{{ $nextDateToLoad }}">{{ __('common.load_more') }}</button>
        </div>
    @endif
</x-guest-layout>

<script type="module">
    const loadMoreBtn = document.querySelector('#loadMorePosts');

    if(loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function(e) {
            e.preventDefault();
            $.ajax({
                method: 'POST',
                url: '{{ $loadMoreItemsRoute }}',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    'date': $('#loadMorePosts').attr('data-date')
                },
                success: function(response) {
                    const postWrapper = document.querySelector('#postsWrapper');
                    // create element from string
                    const element = document.createElement('div');
                    element.innerHTML = response['content'];
                    // declare masonry object
                    var masonry = new Masonry('#postsWrapper', { "percentPosition": true, "itemSelector": ".masonry-item", "columnWidth": ".col-md-4" })
                    // append child element
                    postWrapper.appendChild(element)
                    masonry.appended(element)
                    // set new date for loading
                    $('#loadMorePosts').attr('data-date', response['date']);
                    if (response['date'] === null) {
                        $('#loadMorePosts').hide();
                    }
                },
                error: function(error) {
                    console.error(error);
                }
            });
        })
    }

    document.addEventListener('DOMContentLoaded', function () {
        $('#date').datepicker({
            dateFormat: "dd.mm.yy.",
            autoSize: true,
            language: "hr",
            maxDate: '{{ now()->format('d.m.Y.') }}',
        });
    });
</script>

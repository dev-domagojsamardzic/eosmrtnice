<x-guest-layout>
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
    const searchBtn = document.querySelector('#submitPostSearch');

    loadMoreBtn.addEventListener('click', function(e) {
        e.preventDefault();
        $.ajax({
            method: 'POST',
            url: '{{ route('homepage.items') }}',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: {
                'date': $('#loadMorePosts').data('date')
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
                $('#loadMorePosts').data('date', response['date']);
                if (response['date'] === null) {
                    $('#loadMorePosts').hide();
                }
            },
            error: function(error) {
                console.error(error);
            }
        });
    })

    searchBtn.addEventListener('click', function(e){
        e.preventDefault();
        $.ajax({
            method: 'POST',
            url: '{{ route('homepage.search') }}',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: {
                'name' : $('#name').val(),
                'date' : $('#date').val(),
            },
            success: function(response) {
                const postWrapper = document.querySelector('#postsWrapper');
                // create element from string
                const element = document.createElement('div');
                element.innerHTML = response[0];
                // declare masonry object
                var masonry = new Masonry('#postsWrapper', { "percentPosition": true, "itemSelector": ".masonry-item", "columnWidth": ".col-md-4" })
                // append child element
                postWrapper.innerHTML = ""
                postWrapper.appendChild(element)
                /*masonry.appended(element)*/
                masonry.appended(element)
                masonry.layout()
                $('#loadMorePosts').hide();
            },
            error: function(error) {
                console.log('Error searching posts:', error);
            }
        });
    })

    document.addEventListener('DOMContentLoaded', function () {
        $('#date').datepicker({
            dateFormat: "dd.mm.yy.",
            autoSize: true,
            language: "hr",
        });
        console.log('Yipy')
    });
</script>

<x-guest-layout>
    <div class="row"><h1 class="my-4">{{ $title }}</h1></div>
    @include('partials.ads-search')

    <div class="wrapper row" id="ads_content">
        @if($ads->count() === 0)
            @include('partials.ad_preview.no_results')
        @else
            @foreach($ads as $ad)
                @php
                    $view = match($ad->type) {
                        \App\Enums\AdType::PREMIUM => 'partials.ad_preview.premium',
                        \App\Enums\AdType::GOLD => 'partials.ad_preview.gold',
                        default => 'partials.ad_preview.standard',
                    }
                @endphp
                @include($view, ['ad' => $ad])
            @endforeach
        @endif
    </div>
</x-guest-layout>


<script type="module">
    const button = document.querySelector('[name="submit_ad_search"]');
    button.addEventListener('click', function(e){
        e.preventDefault();
        $.ajax({
            method: 'POST',
            url: '{{ route('guest.funerals.items') }}',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: {
                'county' : $('#county').val(),
                'city' : $('#city').val(),
            },
            success: function(response) {
                document.querySelector('#ads_content').innerHTML = response[0];
            },
            error: function(error) {
                console.log('Error fetching ads:', error);
            }
        });
    })
</script>

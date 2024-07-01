<x-guest-layout>
    <h1 class="my-4">{{ __('guest.funerals') }}</h1>
    @include('partials.ads-search')

    <div class="wrapper" id="funerals_content">
        @if($funerals->count() === 0)
            <span class="mt-5">{{ __('common.no_results') }}</span>
        @else
            @foreach($funerals as $funeral)
                @php
                    $view = match($funeral->type) {
                        \App\Enums\AdType::PREMIUM => 'partials.ad_preview.premium',
                        \App\Enums\AdType::GOLD => 'partials.ad_preview.gold',
                        default => 'partials.ad_preview.standard',
                    }
                @endphp
                @include($view, ['ad' => $funeral])
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
            success() {
                //alert('fuck yeah!');
            }
        });
        // return response
        // render
    })
</script>

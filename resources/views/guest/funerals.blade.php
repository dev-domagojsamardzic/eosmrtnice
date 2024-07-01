<x-guest-layout>
    <h1 class="my-4">{{ __('guest.funerals') }}</h1>
    @include('partials.ads-search')

    <div class="container" id="funerals_content">

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

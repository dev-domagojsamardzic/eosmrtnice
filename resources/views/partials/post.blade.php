<div class="d-flex flex-column align-items-center justify-content-center mt-4">
    <div class="d-flex align-items-center justify-content-between w-100">
        <div class="d-flex gap-4">
            <a class="btn btn-outline-primary" href="{{ $social['facebook'] }}">
                <i class="fab fa-facebook-f"></i>
            </a>
            <a class="btn btn-outline-primary" href="{{ $social['whatsapp'] }}">
                <i class="fab fa-whatsapp"></i>
            </a>
        </div>
        <div>
            <a class="btn btn-outline-primary" href="{{ route('guest.condolences.create') }}">
                {{ __('common.send_condolence') }}
            </a>
        </div>
    </div>
    <hr class="hr_gray_500 w-100">
</div>

<div @class([
    'candle_lit' => ($isCandleLit ?? false),
    'full_post_wrapper d-flex flex-column align-items-center justify-content-center'
])>
    {{--<div class="header mt-4">
        {{ $post->type->translate() }}
    </div>--}}

    @if($post->symbol->value)
        <div class="symbol mt-4">
            <img alt="{{ $post->deceased_full_name_lg }}" src="{{ asset("graphics/post_symbol/{$post->symbol->value}.svg") }}"/>
        </div>

        <hr class="hr_gray_500 w-32 mt-4">
    @endif

    @if($post->image)
        <div class="image mt-4">
            <img src="{{ public_storage_asset($post->image ?? '') }}" alt="{{ $post->deceased_full_name_lg }}" />
        </div>
    @endif

    <div class="lifespan mt-3">
        {{ $post->lifespan }}
    </div>

    <div class="deceased_full_name_lg mt-4">
        <h1 class="font-weight-normal">{{ $post->deceased_full_name_lg }}</h1>
    </div>

    @if($post->intro_message)
        <div class="intro_message mt-4">
            {!! $post->intro_message !!}
        </div>
    @endif

    @if($post->deceased_full_name_sm)
        <div class="deceased_full_name_sm mt-4">
            {{ $post->deceased_full_name_sm }}
        </div>
    @endif

    @if($post->main_message)
        <div class="deceased_main_message mt-4">
            {!! $post->main_message !!}
        </div>
    @endif

    @if($post->signature)
        <div class="signature mt-4">
            {!! $post->signature !!}
        </div>
    @endif

    <hr class="hr_gray_500 w-32 my-5">

    <button id="lightCandleBtn" data-id="{{ $post->id }}" @class(['btn-light-a-candle btn btn-outline-dark', 'fire_effect_box_shadow' => ($isCandleLit ?? false)]) title="{{ __('guest.light_a_candle') }}">
        <i class="fas fa-fire mr-2"></i>
        <span class="candles_count font-weight-500">{{ $post->candles }}</span>
    </button>
</div>


<script type="module">
    const lightCandleBtn = document.getElementById('lightCandleBtn');
    const postWrapper = document.querySelector('.full_post_wrapper');

    lightCandleBtn.addEventListener('click', function(e) {

        $.ajax({
            method: 'POST',
            url: '{{ route('posts.candle') }}',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: {
                'post': this.dataset.id,
            },
            success: function(response) {

                if (response['success'])
                {
                    let counter = lightCandleBtn.querySelector('.candles_count').innerText;
                    let count = parseInt(counter) + parseInt(response['increment']);
                    lightCandleBtn.querySelector('.candles_count').innerText = count;

                    postWrapper.style.backgroundColor = '#5c5c5c';
                    postWrapper.style.color = '#ffffff';
                    postWrapper.style.transition = 'all 0.3s ease-in-out';

                    lightCandleBtn.style.boxShadow = '0 0 8px 2px #ffe808,0 0 10px 4px #ff9a00,0 0 14px 6px #ff0000';
                    lightCandleBtn.style.color = '#fff';
                    lightCandleBtn.style.transition = 'all 0.3s ease-in-out';
                }
            },
            error: function(error) {
                console.error(error);
            },
        })
    });
</script>

<div class="full_post_wrapper d-flex flex-column align-items-center justify-content-center">

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

    <button class="btn-light-a-candle btn btn-outline-dark" title="Zapali svijeću">
        <i class="fas fa-fire mr-2"></i>
        <span class="font-weight-500">{{ $post->candles }}</span>
    </button>
</div>

<div id="post-preview-wrapper" @class(["main_post", "border_classic" => !$post->is_framed, "border_special" => $post->is_framed])>
    {{-- Post header--}}
    <div id="type_preview" class="header">
        {{ $post->type->translate() }}
    </div>
    {{-- Post body --}}
    <div class="body">
        {{-- Deceased full name - large --}}
        <div id="deceased_full_name_lg_preview" class="deceased_full_name_lg">
            {{ $post->deceased_full_name_lg }}
        </div>
        {{-- Deceased full name - large --}}

        {{-- Deceased lifespan--}}
        <div id="lifespan_preview" class="lifespan">
            {{ $post->lifespan }}
        </div>
        {{-- Deceased lifespan--}}

        {{-- Images --}}
        <div class="images_wrapper">
            {{-- Deceased image --}}
            <div id="image_preview" class="image" @style([
                'display: none' => !$post->image,
                'display: block' => $post->image
            ])>
                <img id="deceased_image" src="{{ public_storage_asset($post->image ?? '') }}" alt="{{ $post->deceased_full_name_lg }}" />
            </div>
            {{-- Deceased image --}}

            {{-- Symbol image --}}
            <div class="symbol" id="symbol_wrapper" @style(['display:none' => ($post->symbol === \App\Enums\PostSymbol::NONE)])>
                <img id="symbol_image" src="{{ asset("graphics/post_symbol/{$post->symbol->value}.svg") }}"/>
            </div>
            {{-- Symbol image --}}
        </div>
        {{-- Images --}}

        <div class="d-flex align-items-center justify-content-center w-100 mt-5">
            <span class="badge badge-dark p-2" title="{{ __('guest.candles_lit', ['number' => $post->candles]) }}">
                <i class="fas fa-fire mr-2"></i>
                {{ $post->candles }}
            </span>
        </div>
    </div>
    {{-- Post body --}}
</div>

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
    </div>
    {{-- Post body --}}
</div>

<div id="post-preview-wrapper" @class(["post", "border_classic" => !$post->is_framed, "border_special" => $post->is_framed])>
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
            <div class="image">
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

        {{-- Intro message --}}
        <div id="intro_message_preview" class="intro_message">
            {!! $post->intro_message !!}
        </div>
        {{-- Intro message --}}

        {{-- Deceased full name - small --}}
        <div id="deceased_full_name_sm_preview" class="deceased_full_name_sm">
            {{ $post->deceased_full_name_sm }}
        </div>
        {{-- Deceased full name - small --}}

        {{-- Main message --}}
        <div id="main_message_preview" class="deceased_main_message">
            {!! $post->main_message !!}
        </div>
        {{-- Main message --}}

        {{-- Signature --}}
        <div id="signature_preview" class="signature">
            {!! $post->signature !!}
        </div>
        {{-- Signature --}}
    </div>
    {{-- Post body --}}
</div>

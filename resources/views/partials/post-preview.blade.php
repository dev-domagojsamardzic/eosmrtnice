<div id="post-preview-wrapper" class="post {{ $post->is_framed ? 'border_special' : 'border_classic' }}">
    <div id="type_preview" class="header">{{ $post->type->translate() }}</div>
    <div class="body">

        <div id="deceased_full_name_lg_preview" class="deceased_full_name_lg">
            {{ old('deceased_full_name_lg', $deceased->full_name) }}
        </div>

        <div id="lifespan_preview" class="lifespan">
            {{ old('lifespan', $deceased->lifespan) }}
        </div>

        <div class="images_wrapper">
            <div class="image">
                <img src="{{ public_storage_asset($deceased->image) }}" />
            </div>
            <div class="symbol" id="symbol_wrapper" {{ $post->symbol === \App\Enums\PostSymbol::NONE ? 'style="display:none"' : '' }}>
                <img id="symbol_image" src="{{ $post->symbol === \App\Enums\PostSymbol::NONE ? '' : asset("/images/posts/symbols/{$post->symbol->value}.svg") }}"/>
            </div>
        </div>

        <div id="intro_message_preview" class="intro_message">
            {!! old('intro_message', $post->intro_message) !!}
        </div>

        <div id="deceased_full_name_sm_preview" class="deceased_full_name_sm">
            {{ old('deceased_full_name_sm', $post->deceased_full_name_sm) }}
        </div>

        <div id="main_message_preview" class="deceased_main_message">
            {!! old('main_message', $post->main_message) !!}
        </div>

        <div id="signature_preview" class="signature">
            {!! old('signature', $post->signature) !!}
        </div>
    </div>
</div>

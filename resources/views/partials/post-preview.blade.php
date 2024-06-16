<div class="post">
    <div id="type_preview" class="header">{{ $post->type->translate() }}</div>
    <div class="body">

        <div id="deceased_full_name_lg_preview" class="deceased_full_name_lg">
            {{ $deceased->full_name }}
        </div>

        <div id="lifespan_preview" class="lifespan">
            {{ $deceased->lifespan }}
        </div>

        <div class="images_wrapper">
            <div class="image">
                <img src="{{ public_storage_asset($deceased->image) }}" />
            </div>
            <div class="symbol" id="symbol_wrapper">
                <img id="symbol_image" src="{{ asset('images/posts/symbols/cross.svg') }}"/>
            </div>
        </div>

        <div id="intro_message_preview" class="intro_message">
            {!! $post->intro_message !!}
        </div>

        <div id="deceased_full_name_sm_preview" class="deceased_full_name_sm">
            {{ $deceased->full_name }}
        </div>

        <div id="main_message_preview" class="deceased_main_message">
            {!! $post->main_message !!}
        </div>

        <div id="signature_preview" class="signature">
            {!! $post->signature !!}
        </div>
    </div>
</div>

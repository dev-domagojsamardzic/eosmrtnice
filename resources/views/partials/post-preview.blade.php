<div class="post">
    <div class="header">Obavijest o smrti</div>
    <div class="body">

        <div class="deceased_name">
            {{ $deceased->full_name }}
        </div>

        <div class="deceased_lifespan">
            12.02.1978.-14.05.2024.
        </div>

        <div class="deceased_image_wrapper">
            <div class="deceased_image">
                <img src="{{ public_storage_asset($deceased->image) }}" />
            </div>
            <div class="deceased_symbol">
                <img src="{{ public_storage_asset('images/cross.svg') }}"/>
            </div>
        </div>

        <div class="deceased_intro_message">
            {!! $deceased->main_message !!}
        </div>

        <div class="deceased_mid_message_name">{{ $deceased->full_name }}</div>

        <div class="deceased_signature">
            {!! $deceased->signature !!}
        </div>
    </div>
</div>

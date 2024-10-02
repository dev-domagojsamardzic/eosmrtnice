<div class="col-sm-12 col-lg-6 ad_preview_col">
    <div class="ad_preview premium">
        @if($ad->logo)
            <img src="{{ public_storage_asset($ad->logo) }}" class="logo mb-2 rounded-circle" alt="{{ $ad->company_title }}" />
        @endif
        <h5 class="mb-5">{{ $ad->company_title }}</h5>
        @if($ad->company_address)
            <p class="text-black">
                <i class="fas fa-home icon-fixed-width-20" title="{{ __('guest.address') }}"></i>
                <span class="ml-2">{{ $ad->company->address }}</span>
            </p>
        @endif
        @if($ad->city)
            <p class="text-black">
                <i class="fas fa-map-marker-alt icon-fixed-width-20" title="{{ __('guest.city') }}"></i>
                <span class="ml-2">{{ $ad->city->title }}</span>
            </p>
        @endif
        @if($ad->company_phone)
            <p class="text-black">
                <i class="fas fa-phone icon-fixed-width-20" title="{{ __('guest.phone') }}"></i>
                <span class="ml-2">{{ $ad->company_phone }}</span>
            </p>
        @endif
        @if($ad->company_mobile_phone)
            <p class="text-black">
                <i class="fas fa-mobile-alt icon-fixed-width-20" title="{{ __('guest.mobile_phone') }}"></i>
                <span class="ml-2">{{ $ad->company_mobile_phone }}</span>
            </p>
        @endif
        @if($ad->company_website)
            <p class="text-black">
                <i class="fas fa-globe icon-fixed-width-20" title="{{ __('guest.web') }}"></i>
                <span class="ml-2">
                    <a target="_blank" href="{{ $ad->company_website }}">{{ $ad->company_website }}</a>
                </span>
            </p>
        @endif
    </div>
</div>

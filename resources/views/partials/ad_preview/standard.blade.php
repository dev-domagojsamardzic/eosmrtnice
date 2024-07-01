<div class="ad_preview col-sm-12 col-lg-6">
    <h5 class="mb-5">{{ $ad->company->title }}</h5>
    @if($ad->company?->address)
        <p class="text-black">{{ __('guest.address') }}:<span class="ml-2">{{ $ad->company->address }}</span></p>
    @endif
    @if($ad->company->town || $ad->company?->city?->title)
        <p class="text-black">{{ __('guest.city') }}:
            <span class="ml-2">
                {{ implode(' / ', [$ad->company?->city?->title, $ad->company->town]) }}
            </span></p>
    @endif
    @if($ad->company?->county?->title)
        <p class="text-black">{{ __('guest.county') }}:<span class="ml-2">{{ $ad->company->county->title }}</span></p>
    @endif
    @if($ad->company?->phone)
        <p class="text-black">{{ __('guest.phone') }}:<span class="ml-2">{{ $ad->company->phone }}</span></p>
    @endif
    @if($ad->company?->mobile_phone)
        <p class="text-black">{{ __('guest.mobile_phone') }}:<span class="ml-2">{{ $ad->company->mobile_phone }}</span></p>
    @endif
    @if($ad->company?->email)
        <p class="text-black">{{ __('guest.email') }}:<span class="ml-2">{{ $ad->company->email }}</span></p>
    @endif
    @if($ad->company?->website)
        <p class="text-black">{{ __('guest.web') }}:
            <span class="ml-2">
                <a target="_blank" href="{{ $ad->company->website }}">{{ $ad->company->website }}</a>
            </span>
        </p>
    @endif
</div>

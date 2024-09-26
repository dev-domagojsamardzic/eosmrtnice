<footer class="bottom-bar pb-5">
    <div class="row">
        <div class="d-flex col-md-6 offset-md-3 col-sm-12 align-items-center justify-content-center p-2">
            <img style="max-height: 80px; width: auto;" alt="{{ config('app.name') }}" src="{{ asset('graphics/logo/logo-dark.svg') }}">
        </div>
    </div>
    <div class="row">
        <div class="d-flex flex-col align-items-center justify-content-center col-md-4 col-sm-12 mt-3">
            <div class="col-12">
                <div class="text-center p-1">
                    <b>Izbornik</b>
                </div>
                <div class="text-center p-1">
                    <a href="{{ route('guest.death-notices') }}" @class(['text-black'])>{{ __('guest.death_notices') }}</a>
                </div>
                <div class="text-center p-1">
                    <a href="{{ route('guest.last-goodbyes') }}" @class(['text-black'])>{{ __('guest.last_goodbyes') }}</a>
                </div>
                <div class="text-center p-1">
                    <a href="{{ route('guest.memories') }}" @class(['text-black'])>{{ __('guest.memories') }}</a>
                </div>
                <div class="text-center p-1">
                    <a href="{{ route('guest.thank-yous') }}" @class(['text-black'])>{{ __('guest.thank_yous') }}</a>
                </div>

                <div class="text-center p-1">
                    <a href="{{ route('guest.funerals') }}" @class(['text-black', 'navbar-item-active' => request()->routeIs('guest.funerals')])>
                        {{ __('guest.funerals') }}
                    </a>
                </div>
                <div class="text-center p-1">
                    <a href="{{ route('guest.masonries') }}" @class(['text-black', 'navbar-item-active' => request()->routeIs('guest.masonries')])>
                        {{ __('guest.masonries') }}
                    </a>
                </div>
                <div class="text-center p-1">
                    <a href="{{ route('guest.flowers') }}" @class(['text-black', 'navbar-item-active' => request()->routeIs('guest.flowers')])>
                        {{ __('guest.florists') }}
                    </a>
                </div>
            </div>
        </div>
        <div class="d-flex flex-col align-items-center justify-content-center col-md-4 col-sm-12 mt-3">
            <div class="col-12">
                <div class="text-center p-1">
                    <b>Korisni linkovi</b>
                </div>
                <div class="text-center p-1">
                    <a href="#" @class(['text-black'])>#Uvjeti korištenja</a>
                </div>
                <div class="text-center p-1">
                    <a href="#" @class(['text-black'])>#Uvjeti kupnje</a>
                </div>
                <div class="text-center p-1">
                    <a href="#" @class(['text-black'])>#Politika privatnosti</a>
                </div>
            </div>

        </div>
        <div class="d-flex flex-col align-items-center justify-content-center col-md-4 col-sm-12 mt-3">
            <div class="col-12">
                <div class="text-center p-1">
                    <b>Info</b>
                </div>
                <div class="text-center p-1">
                    <i class="fas fa-envelope mr-2"></i>
                    <a href="mailto:{{ config('eosmrtnice.company.info_email') }}" @class(['text-black'])>
                        {{ config('eosmrtnice.company.info_email') }}
                    </a>
                </div>
                <div class="text-center p-1">
                    <i class="fas fa-phone mr-2"></i>
                    <a href="tel:{{ config('eosmrtnice.company.phone') }}" @class(['text-black'])>
                        {{ config('eosmrtnice.company.phone') }}
                    </a>
                </div>
                {{--<div class="text-center p-1">
                    <i class="fas fa-mobile-phone mr-2"></i>
                    <a href="tel:{{ config('eosmrtnice.company.phone') }}" @class(['text-black'])>
                        {{ config('eosmrtnice.company.mobile_phone') }}
                    </a>
                </div>--}}
                <div class="text-center p-1">
                    <i class="fas fa-map-marked-alt mr-2"></i>
                    <span class="text-black">{{ config('eosmrtnice.company.full_address') }}</span>
                </div>
                <div class="text-center p-1">
                    <b>OIB: </b><span class="text-black">{{ config('eosmrtnice.company.oib') }}</span>
                </div>
                <div class="text-center p-1">
                    <b>MBS: </b><span class="text-black">{{ config('eosmrtnice.company.mbs') }}</span>
                </div>
            </div>
        </div>
    </div>
</footer>

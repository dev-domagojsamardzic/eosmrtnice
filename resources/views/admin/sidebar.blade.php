<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion toggled" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route(auth_user_type() . '.dashboard') }}">
        <div class="sidebar-brand-icon">
            <img height="40" src="{{ asset('graphics/logo/logo-light.svg') }}" alt="{{ config('app.name') }}">
        </div>
        <div class="sidebar-brand-text mx-3 mt-3">{{ config('app.name') }}</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route(auth_user_type() . '.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>{{ __('common.dashboard') }}</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Nav Item - Partners -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route(auth_user_type() . '.partners.index') }}">
            <i class="fas fa-handshake"></i>
            <span>{{ __('sidebar.partners') }}</span></a>
    </li>

    <!-- Nav Item - Users -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route(auth_user_type() . '.members.index') }}">
            <i class="fas fa-users"></i>
            <span>{{ __('sidebar.users') }}</span></a>
    </li>

    <!-- Nav Item - Companies -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route(auth_user_type() . '.companies.index') }}">
            <i class="fas fa-building"></i>
            <span>{{ __('sidebar.companies') }}</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Condolence addons-->
    <li class="nav-item">
        <a class="nav-link" href="{{ route(auth_user_type() . '.condolence-addons.index') }}">
            <i class="fas fa-puzzle-piece"></i>
            <span>{{ __('sidebar.condolence_addons') }}</span></a>
    </li>

    <!-- Ads types-->
    <li class="nav-item">
        <a class="nav-link" href="{{ route(auth_user_type() . '.ad-types.index') }}">
            <i class="fas fa-puzzle-piece"></i>
            <span>{{ __('sidebar.ad_types') }}</span></a>
    </li>

    <!-- Post products-->
    <li class="nav-item">
        <a class="nav-link" href="{{ route(auth_user_type() . '.post-products.index') }}">
            <i class="fas fa-puzzle-piece"></i>
            <span>{{ __('sidebar.post_products') }}</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Nav Item - Ads -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route(auth_user_type() . '.ads.index') }}">
            <i class="fas fa-ad"></i>
            <span>{{ __('sidebar.ads') }}</span></a>
    </li>

    <!-- Nav Item - Posts -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route(auth_user_type() . '.posts.index') }}">
            <i class="fas fa-address-card"></i>
            <span>{{ __('sidebar.posts') }}</span></a>
    </li>

    <!-- Nav Item - Posts -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.condolences.index') }}">
            <i class="fas fa-hand-holding-heart"></i>
            <span>{{ __('sidebar.condolences') }}</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Nav Item - Offers for ads -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route(auth_user_type() . '.ads-offers.index') }}">
            <i class="fas fa-file-pdf"></i>
            <span>{{ __('sidebar.ads_offers') }}</span></a>
    </li>

    <!-- Nav Item - Offers for posts -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route(auth_user_type() . '.posts-offers.index') }}">
            <i class="fas fa-file-pdf"></i>
            <span>{{ __('sidebar.posts_offers') }}</span></a>
    </li>

    <!-- Nav Item - Offers for condolences -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route(auth_user_type() . '.condolences-offers.index') }}">
            <i class="fas fa-file-pdf"></i>
            <span>{{ __('sidebar.condolences_offers') }}</span></a>
    </li>

    <!-- Nav Item - Services -->
    {{--<li class="nav-item">
        <a class="nav-link" href="{{ route(auth_user_type() . '.services.index') }}">
            <i class="fas fa-tag"></i>
            <span>{{ __('sidebar.services') }}</span></a>
    </li>--}}

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>

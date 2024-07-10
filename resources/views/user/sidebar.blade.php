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

    <!-- Nav Item - Posts -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route(auth_user_type() . '.posts.index') }}">
            <i class="fas fa-address-card"></i>
            <span>{{ __('sidebar.posts') }}</span></a>
    </li>

    <!-- Nav Item - Offers -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route(auth_user_type() . '.posts-offers.index') }}">
            <i class="fas fa-file-pdf"></i>
            <span>{{ __('sidebar.posts_offers') }}</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>

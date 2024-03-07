<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route(auth_user_type() . '.dashboard') }}">
        <div class="sidebar-brand-icon">
            <img height="40" src="{{ asset('storage/images/logo_vector_white.svg') }}" alt="{{ config('app.name') }}">
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

    <!-- Heading -->
    <div class="sidebar-heading">
        {{ __('sidebar.accounts') }}
    </div>

    <!-- Nav Item - Partners -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-handshake"></i>
            <span>{{ __('sidebar.partners') }}</span></a>
    </li>

    <!-- Nav Item - Users -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-users"></i>
            <span>{{ __('sidebar.users') }}</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>

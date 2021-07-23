@php
$settings = App\Models\Setting::first();
$theme = $settings->admin_theme;
@endphp

@if ($theme == 'light')
<style>
    .bg-gradient-primary {
        background-color: #fafafa;
        background-image: -webkit-gradient(linear, left top, left bottom, color-stop(10%, #fafafa), to(#fafafa));
        background-image: linear-gradient(180deg, #fafafa, #fafafa 100%);
        background-size: cover;
    }

    .sidebar-dark .nav-item .nav-link:active,
    .sidebar-dark .nav-item .nav-link:focus,
    .sidebar-dark .nav-item .nav-link:hover {
        color: #263238;
        background: #f6f6f6;
    }

    .sidebar-dark .nav-item .nav-link {
        color: #263238;
    }

    .sidebar-dark .nav-item.active .nav-link {
        color: #263238;
    }

    .sidebar-dark .nav-item .nav-link[data-toggle=collapse]::after {
        color: #607D8B;
    }

    .sidebar-dark .nav-item .nav-link i {
        color: #607D8B;
    }

    .sidebar-dark .nav-item .nav-link:active i,
    .sidebar-dark .nav-item .nav-link:focus i,
    .sidebar-dark .nav-item .nav-link:hover i {
        color: #263238;
    }

    .sidebar-dark .nav-item.active .nav-link i {
        color: #607D8B;
    }

    .sidebar .nav-item .nav-link {
        background: #fafafa;
        margin-top: 1px;
    }

    .topbar {
        background: #fafafa !important;
    }

    .sidebar .sidebar-brand {
        background: #fafafa;
    }

    .sidebar-brand-text {
        color: #37474F !important;
    }

    .sidebar-brand-icon {
        color: #37474F !important;
    }

    #wrapper #content-wrapper {
        background-color: #fff;
    }

    .sidebar .nav-item .collapse .collapse-inner .collapse-item.active,
    .sidebar .nav-item .collapsing .collapse-inner .collapse-item.active {
        color: #607D8B;
        font-weight: 700;
    }

    .sidebar-dark #sidebarToggle {
        background-color: #eee;
    }

    .sidebar-dark #sidebarToggle:hover {
        background-color: rgba(158, 158, 158, 0.33);
    }
</style>
@endif


@if ($theme == 'dark')
<style>
    .sidebar .sidebar-brand .sidebar-brand-text {
        color: white;
    }

    .sidebar .sidebar-brand .sidebar-brand-icon i {
        color: #fff;
    }

    .bg-gradient-primary {
        background-color: #263238 !important;
        background-image: -webkit-gradient(linear, left top, left bottom, color-stop(10%, #263238), to(#263238b8));
        background-image: linear-gradient(180deg, #263238 10%, #263238b8 100%);
    }

    .admin-navbar {
        background: #263238 !important;
    }
</style>
@endif

@if ($theme == 'primary')
<style>
    .bg-gradient-primary {
        background-color: #20639B;
        background-image: -webkit-gradient(linear, left top, left bottom, color-stop(10%, #20639B), to(#20639B));
        background-image: linear-gradient(180deg, #20639B 10%, #20639B 100%);
        background-size: cover;
    }

    .sidebar .sidebar-brand {
        background: #20639B;
    }

    .sidebar-brand-text {
        color: #FFF !important;
    }

    .sidebar-brand-icon {
        color: #FFF !important;
    }

    .topbar {
        background: #20639B !important;
    }

    .nav-item .text-gray-600 {
        color: #ffffff !important;
    }
</style>
@endif
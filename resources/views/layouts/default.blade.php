<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
dir="{{ Helper::determineLanguageDirection() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        @section('title')
        @show
        :: {{ $snipeSettings->site_name }}
    </title>
    <meta content="width=device-width, initial-scale=1" name="viewport">

    <meta name="apple-mobile-web-app-capable" content="yes">


    <link rel="apple-touch-icon"
          href="{{ ($snipeSettings) && ($snipeSettings->favicon!='') ?  Storage::disk('public')->url(e($snipeSettings->logo)) :  config('app.url').'/img/snipe-logo-bug.png' }}">
    <link rel="apple-touch-startup-image"
          href="{{ ($snipeSettings) && ($snipeSettings->favicon!='') ?  Storage::disk('public')->url(e($snipeSettings->logo)) :  config('app.url').'/img/snipe-logo-bug.png' }}">
    <link rel="shortcut icon" type="image/ico"
          href="{{ ($snipeSettings) && ($snipeSettings->favicon!='') ?  Storage::disk('public')->url(e($snipeSettings->favicon)) : config('app.url').'/favicon.ico' }}">


    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="language" content="{{ Helper::mapBackToLegacyLocale(app()->getLocale()) }}">
    <meta name="language-direction" content="{{ Helper::determineLanguageDirection() }}">
    <meta name="baseUrl" content="{{ config('app.url') }}/">

    <script nonce="{{ csrf_token() }}">
        window.Laravel = {csrfToken: '{{ csrf_token() }}'};
    </script>

    {{-- stylesheets --}}
    <link rel="stylesheet" href="{{ url(mix('css/dist/all.css')) }}">
    @if (($snipeSettings) && ($snipeSettings->allow_user_skin==1) && Auth::check() && Auth::user()->present()->skin != '')
        <link rel="stylesheet" href="{{ url(mix('css/dist/skins/skin-'.Auth::user()->present()->skin.'.min.css')) }}">
    @else
        <link rel="stylesheet"
              href="{{ url(mix('css/dist/skins/skin-'.($snipeSettings->skin!='' ? $snipeSettings->skin : 'blue').'.css')) }}">
    @endif
    {{-- page level css --}}
    @stack('css')

    {{-- Custom CSS --}}
    @if (($snipeSettings) && ($snipeSettings->custom_css))
        <style>
            {!! $snipeSettings->show_custom_css() !!}
        </style>
    @endif


    <script nonce="{{ csrf_token() }}">
        window.snipeit = {
            settings: {
                "per_page": {{ $snipeSettings->per_page }}
            }
        };
    </script>

    <script src="{{ url(asset('js/html5shiv.js')) }}" nonce="{{ csrf_token() }}"></script>
    <script src="{{ url(asset('js/respond.js')) }}" nonce="{{ csrf_token() }}"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.css" />
<style>
    /* Kustomisasi warna Loading Bar jadi Biru/Sesuai Tema */
    #nprogress .bar {
        background: #3b82f6 !important; /* Warna Biru */
        height: 3px !important;
        box-shadow: 0 0 10px #3b82f6, 0 0 5px #3b82f6;
    }
    #nprogress .spinner { display: none; } /* Hilangkan spinner lingkaran kanan atas */
</style>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<style>
    /* =========================================================
       1. GLOBAL & TYPOGRAPHY
       ========================================================= */
    /* Import Font Inter */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

    body, h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6 {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif !important;
    }
    body {
        background-color: #f3f4f6;
        color: #1f2937;
        font-size: 14px;
    }

    /* =========================================================
       2. MODERN HEADER & NAVBAR (FIXED FOR LONG NAMES)
       ========================================================= */
    
    /* A. Reset Header Layout & Paksa Warna Putih */
    .main-header {
        max-height: 70px !important;
        height: 70px !important;
        box-shadow: 0 1px 15px rgba(0,0,0,0.04);
        background-color: #ffffff !important;
        z-index: 1030;
        position: relative;
    }

    /* B. Override Warna Bawaan (Hapus Biru/Tosca) */
    .skin-blue .main-header .navbar,
    .skin-blue .main-header .logo,
    .skin-blue .main-header .logo:hover,
    .main-header .navbar, 
    .main-header .logo {
        background-color: #ffffff !important;
        background: #ffffff !important;
        border-bottom: 1px solid #f3f4f6;
        transition: none !important;
    }

    /* C. Logo Area Fixing (SOLUSI NAMA PANJANG) */
    .main-header .logo {
        height: 70px !important;
        line-height: 70px !important;
        color: #1f2937 !important; /* Warna teks hitam */
        font-weight: 800;
        letter-spacing: -0.3px;
        text-align: left;
        padding-left: 20px;
        padding-right: 10px;
        width: 230px !important; /* Lebar Sidebar */
        border-right: 1px solid #f3f4f6;
        display: block; /* Ganti flex ke block agar ellipsis jalan */
        float: left !important;
        
        /* Logika Pemotongan Teks Panjang */
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
        font-size: 18px !important; /* Ukuran font disesuaikan agar muat */
    }
    
    /* Styling gambar logo kecil di sebelah teks */
    .main-header .logo .navbar-brand-img {
        max-height: 30px !important;
        margin-right: 8px;
        margin-top: -4px; /* Center vertical adjustment */
        vertical-align: middle;
        display: inline-block;
    }
    
    /* Span teks nama situs */
    .main-header .logo span {
        vertical-align: middle;
    }

    /* D. Navbar Container */
    .main-header .navbar {
        height: 70px !important;
        margin-left: 230px !important; 
        border: none !important;
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        padding: 0 30px 0 0px !important; /* Padding kiri 0 karena ada toggle button */
    }

    /* E. Hamburger Toggle Button (FIXED POSITION) */
    .main-header .sidebar-toggle {
        color: #6b7280 !important;
        width: 50px !important; /* Lebar pasti */
        height: 70px !important;
        line-height: 70px !important;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 !important;
        font-size: 18px;
        float: left; 
        background: transparent !important;
        border-right: 1px solid transparent;
    }
    .main-header .sidebar-toggle:hover {
        background: #f9fafb !important;
        color: #3b82f6 !important;
    }
    .main-header .sidebar-toggle:before { content: none !important; }

    /* F. Search Bar (Pill Shape) */
    .navbar-form {
        border: none !important;
        box-shadow: none !important;
        margin: 0 !important;
        padding: 0 !important;
        display: flex;
        align-items: center;
        margin-left: 10px !important; /* Jarak dari tombol hamburger */
    }
    #tagSearch {
        height: 40px !important;
        border-radius: 50px !important;
        background-color: #f3f4f6 !important;
        border: 1px solid transparent !important;
        width: 280px !important;
        padding-left: 20px;
        color: #374151;
        transition: all 0.3s;
    }
    #tagSearch:focus {
        background-color: #fff !important;
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1) !important;
        width: 350px !important;
    }
    #topSearchButton {
        margin-left: -40px !important;
        background: #3b82f6 !important;
        border-radius: 50%;
        width: 34px;
        height: 34px;
        border: none !important;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 10;
        box-shadow: 0 2px 5px rgba(59, 130, 246, 0.3);
    }

    /* G. Right Menu Icons */
    .navbar-custom-menu > .navbar-nav {
        display: flex; 
        flex-direction: row; 
        align-items: center; 
        height: 70px;
        margin: 0;
    }
    .navbar-nav > li {
        float: none !important;
        display: inline-block;
        margin-left: 4px;
    }
    .navbar-nav > li > a {
        height: 40px;
        width: 40px;
        padding: 0 !important;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6b7280 !important;
        border-radius: 10px;
        transition: all 0.2s;
        margin-top: 0 !important;
    }
    .navbar-nav > li > a:hover, .navbar-nav > li.open > a {
        background-color: #f3f4f6 !important;
        color: #111827 !important;
    }
    
    /* User Profile Image */
    .navbar-nav > .user-menu .user-image {
        width: 36px; height: 36px;
        border-radius: 50%;
        margin-right: 0;
        border: 2px solid #fff;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        float: none;
    }
    .navbar-nav > .user-menu > a {
        width: auto !important;
        padding: 0 10px !important;
        gap: 8px;
    }

    /* =========================================================
       3. COMPONENT STYLES (Box, Button, Form)
       ========================================================= */
    .box {
        border-radius: 16px !important;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03) !important;
        border: none !important;
        background: #fff;
        margin-bottom: 30px !important;
    }
    .box-header {
        padding: 20px 30px !important;
        border-bottom: 1px solid #f3f4f6;
        border-radius: 16px 16px 0 0 !important;
    }
    .box-title {
        font-weight: 700 !important;
        font-size: 18px !important;
        color: #111827;
        letter-spacing: -0.5px;
    }
    .box-body { padding: 30px !important; }
    .box-footer {
        background-color: #fff !important;
        border-top: 1px solid #f3f4f6 !important;
        border-radius: 0 0 16px 16px !important;
        padding: 20px 30px !important;
    }

    /* BUTTONS */
    .btn {
        border-radius: 8px !important;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        font-weight: 600;
        border: 1px solid transparent !important;
        padding: 8px 20px;
        transition: all 0.2s ease;
        font-size: 13px;
        letter-spacing: 0.3px;
    }
    .btn-primary { background-color: #3b82f6 !important; color: #fff !important; box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.3); }
    .btn-success { background-color: #10b981 !important; color: #fff !important; box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.3); }
    .btn-danger { background-color: #ef4444 !important; color: #fff !important; }
    .btn-warning { background-color: #f59e0b !important; color: #fff !important; }
    .btn-default {
        background-color: #fff !important;
        border: 1px solid #e5e7eb !important;
        color: #374151 !important;
    }
    .btn:hover { transform: translateY(-2px); box-shadow: 0 6px 8px -1px rgba(0,0,0,0.1); opacity: 0.95; }

    /* FORMS */
    .form-control, .select2-selection--single {
        border-radius: 10px !important;
        height: 45px !important;
        border: 1px solid #e5e7eb !important;
        background-color: #f9fafb !important;
        box-shadow: none !important;
    }
    .form-control:focus {
        border-color: #3b82f6 !important;
        background-color: #fff !important;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1) !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 43px !important; padding-left: 15px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow { height: 43px !important; }

    /* =========================================================
       4. TABLE STYLES
       ========================================================= */
    .table > thead > tr > th {
        background-color: #f9fafb;
        color: #6b7280;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 0.05em;
        border-bottom: 1px solid #e5e7eb !important;
        padding: 12px 15px !important;
        white-space: nowrap !important;
    }
    .table > tbody > tr > td {
        padding: 10px 15px !important;
        vertical-align: middle !important;
        border-top: 1px solid #f3f4f6 !important;
        color: #4b5563;
        white-space: nowrap !important;
        max-width: 300px;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .table-striped > tbody > tr:hover {
        background-color: #ffffff !important;
        transform: scale(1.002);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        z-index: 10;
        border-left: 3px solid #3b82f6;
    }
    .table-striped > tbody > tr:hover > td {
        border-top-color: transparent !important;
        border-bottom-color: transparent !important;
    }
    .fixed-table-toolbar .btn-group > .btn {
        border-radius: 8px !important; margin: 0 2px;
        background-color: #fff !important; border: 1px solid #e5e7eb !important;
        color: #4b5563 !important; height: 38px;
    }
    .bootstrap-table .fixed-table-container {
        border: 1px solid #f3f4f6 !important; border-radius: 16px; overflow: visible; 
    }

    /* =========================================================
       5. MODERN SIDEBAR
       ========================================================= */
    .main-sidebar, .left-side {
        background-color: #ffffff !important;
        border-right: 1px solid #e5e7eb;
        padding-top: 10px;
    }
    /* Menu Item */
    .sidebar-menu > li > a {
        color: #4b5563 !important;
        font-weight: 500;
        border-radius: 12px !important;
        margin: 4px 12px !important;
        padding: 12px 16px !important;
        border: none !important;
        transition: all 0.2s ease-in-out;
        display: flex;
        align-items: center;
    }
    .sidebar-menu > li > a > i, .sidebar-menu > li > a > svg {
        margin-right: 12px;
        font-size: 18px;
        color: #9ca3af;
        width: 24px;
        text-align: center;
        transition: color 0.2s;
    }
    /* Active & Hover State */
    .sidebar-menu > li:hover > a,
    .sidebar-menu > li.active > a,
    .sidebar-menu > li.menu-open > a {
        background-color: #eff6ff !important;
        color: #3b82f6 !important;
    }
    .sidebar-menu > li:hover > a > i,
    .sidebar-menu > li.active > a > i {
        color: #3b82f6 !important;
    }
    /* Remove Left Border from old theme */
    .skin-blue .sidebar-menu > li:hover > a, 
    .skin-blue .sidebar-menu > li.active > a { border-left: none !important; }

    /* Submenu (Treeview) */
    .sidebar-menu .treeview-menu {
        background-color: transparent !important; margin-top: 2px; padding-left: 5px;
    }
    .treeview-menu > li > a {
        color: #6b7280 !important; padding: 8px 15px 8px 45px !important; border-radius: 8px; margin: 2px 12px;
    }
    .treeview-menu > li > a:hover, .treeview-menu > li.active > a {
        color: #3b82f6 !important; background-color: rgba(59, 130, 246, 0.05) !important; font-weight: 600;
    }

    /* Collapsed Sidebar Fixes */
    .sidebar-collapse .sidebar-menu > li > a {
        margin: 0 !important; border-radius: 0 !important; padding: 15px 5px !important; justify-content: center;
    }
    .sidebar-collapse .sidebar-menu > li > a > span { display: none !important; }
    .sidebar-collapse .sidebar-menu > li:hover > .treeview-menu {
        background-color: #fff !important; border-radius: 0 12px 12px 0;
        box-shadow: 5px 5px 20px rgba(0,0,0,0.1); border: 1px solid #e5e7eb;
        padding: 10px 0; left: 50px !important; width: 220px;
    }

    /* =========================================================
       6. MOBILE RESPONSIVE
       ========================================================= */
    @media (max-width: 767px) {
        .main-header .navbar { margin-left: 0 !important; padding: 0 10px !important; }
        .main-header .logo { display: none !important; }
        .navbar-custom-menu > .navbar-nav { margin: 0; }
        #tagSearch { width: 100% !important; min-width: 150px; }
        .sidebar-open .main-sidebar { transform: translate(0, 0); }
    }
    @media (min-width: 768px) {
        .sidebar-mini.sidebar-collapse .main-header .navbar { margin-left: 50px !important; }
        .sidebar-mini.sidebar-collapse .main-header .logo { width: 50px !important; border-right: none; }
    }
    /* =========================================================
       7. ANIMATIONS (NEW ADDITION)
       ========================================================= */
    
    /* B. Modal / Popup Animation (Zoom In) */
    .modal.fade .modal-dialog {
        transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        transform: scale(0.8); /* Mulai dari kecil */
        opacity: 0;
    }
    .modal.fade.in .modal-dialog {
        transform: scale(1); /* Zoom ke normal */
        opacity: 1;
    }

    /* C. Form Control Focus Animation */
    .form-control {
        transition: all 0.3s ease;
    }
    
    /* D. Button Loading Spinner Style */
    .btn-loading {
        position: relative;
        color: transparent !important;
        pointer-events: none;
    }
    .btn-loading:after {
        content: '';
        position: absolute;
        width: 16px;
        height: 16px;
        top: 50%;
        left: 50%;
        margin-top: -8px;
        margin-left: -8px;
        border: 2px solid #ffffff;
        border-radius: 50%;
        border-top-color: transparent;
        animation: spin 0.8s linear infinite;
    }
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
</style>
</head>

@if (($snipeSettings) && ($snipeSettings->allow_user_skin==1) && Auth::check() && Auth::user()->present()->skin != '')
    <body class="sidebar-mini skin-{{ $snipeSettings->skin!='' ? Auth::user()->present()->skin : 'blue' }} {{ (session('menu_state')!='open') ? 'sidebar-mini sidebar-collapse' : ''  }}">
    @else
        <body class="sidebar-mini skin-{{ $snipeSettings->skin!='' ? $snipeSettings->skin : 'blue' }} {{ (session('menu_state')!='open') ? 'sidebar-mini sidebar-collapse' : ''  }}">
        @endif


        <a class="skip-main" href="#main">{{ trans('general.skip_to_main_content') }}</a>
        <div class="wrapper">

           <header class="main-header">

    <a href="{{ config('app.url') }}" class="logo">
        @if ($snipeSettings->logo!='')
            <img class="navbar-brand-img" style="max-height: 40px;" 
                 src="{{ Storage::disk('public')->url($snipeSettings->logo) }}" 
                 alt="{{ $snipeSettings->site_name }}">
        @endif
        <span class="{{ $snipeSettings->logo!='' ? 'hidden-xs' : '' }}">{{ $snipeSettings->site_name }}</span>
    </a>

    <nav class="navbar navbar-static-top" role="navigation">
        
        <div style="display: flex; align-items: center; flex-grow: 1;">
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <i class="fa fa-bars"></i> <span class="sr-only">{{ trans('general.toggle_navigation') }}</span>
            </a>

            @can('index', \App\Models\Asset::class)
                <form class="navbar-form hidden-xs" role="search" style="flex-grow: 1; max-width: 600px;"
                      action="{{ route('findbytag/hardware') }}" method="get">
                    <div class="input-group" style="width: 100%; display:flex; align-items:center;">
                        <input type="text" class="form-control" id="tagSearch" name="assetTag" 
                               placeholder="Search assets, licenses, etc..." 
                               style="background-color: #f3f4f6;">
                        
                        <button type="submit" id="topSearchButton" class="btn btn-primary">
                            <i class="fa fa-search"></i>
                        </button>
                        <input type="hidden" name="topsearch" value="true" id="search">
                    </div>
                </form>
            @endcan
        </div>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                
                @can('admin')
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" title="{{ trans('general.create') }}">
                            <i class="fa fa-plus"></i>
                        </a>
                        <ul class="dropdown-menu">
                            @can('create', \App\Models\Asset::class)
                                <li{!! (request()->is('hardware/create') ? ' class="active"' : '') !!}>
                                    <a href="{{ route('hardware.create') }}">
                                        <x-icon type="assets" class="fa-fw" /> {{ trans('general.asset') }}
                                    </a>
                                </li>
                            @endcan
                            @can('create', \App\Models\License::class)
                                <li><a href="{{ route('licenses.create') }}"><x-icon type="licenses" class="fa-fw" /> {{ trans('general.license') }}</a></li>
                            @endcan
                             @can('create', \App\Models\User::class)
                                <li><a href="{{ route('users.create') }}"><x-icon type="users" class="fa-fw" /> {{ trans('general.user') }}</a></li>
                            @endcan
                        </ul>
                    </li>
                @endcan

                @can('index', \App\Models\Asset::class)
                    <li class="hidden-xs">
                        <a href="{{ url('hardware') }}" title="{{ trans('general.assets') }}">
                            <i class="fa fa-barcode"></i>
                        </a>
                    </li>
                @endcan
                
                @can('view', \App\Models\License::class)
                    <li class="hidden-xs">
                        <a href="{{ route('licenses.index') }}" title="{{ trans('general.licenses') }}">
                            <i class="fa fa-save"></i>
                        </a>
                    </li>
                @endcan

                @if (Auth::check())
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="padding-right: 0 !important;">
                            @if (Auth::user()->present()->gravatar())
                                <img src="{{ Auth::user()->present()->gravatar() }}" class="user-image" alt="User Image">
                            @else
                                <i class="fa fa-user-circle fa-2x"></i>
                            @endif
                            <span class="hidden-xs" style="margin-left: 8px; font-weight: 600; color: #374151;">
                                {{ Auth::user()->first_name }}
                            </span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{ route('profile') }}">
                                    <i class="fa fa-user fa-fw"></i> {{ trans('general.editprofile') }}
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="{{ route('logout.get') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-danger">
                                    <i class="fa fa-sign-out fa-fw"></i> {{ trans('general.logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout.post') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                @endif

                @can('superadmin')
                    <li>
                        <a href="{{ route('settings.index') }}" title="Settings">
                            <i class="fa fa-cogs"></i>
                        </a>
                    </li>
                @endcan
            </ul>
        </div>
    </nav>
</header>

            <aside class="main-sidebar">
                <section class="sidebar">
                    <ul class="sidebar-menu" data-widget="tree" {{ \App\Helpers\Helper::determineLanguageDirection() == 'rtl' ? 'style="margin-right:12px' : '' }}>
                        
                        {{-- ==================================================== --}}
                        {{-- MODIFIKASI: DASHBOARD UNTUK USER BIASA --}}
                        {{-- ==================================================== --}}
                        
                        @if(Auth::check())
                            @can('admin')
                                {{-- Dashboard Admin (Halaman Statistik) --}}
                                <li {!! (\Request::route()->getName()=='home' ? ' class="active"' : '') !!} class="firstnav">
                                    <a href="{{ route('home') }}">
                                        <x-icon type="dashboard" class="fa-fw" />
                                        <span>{{ trans('general.dashboard') }}</span>
                                    </a>
                                </li>
                            @else
                                {{-- Dashboard User (Halaman Aset Saya) --}}
                                <li {!! (\Request::route()->getName()=='view-assets' ? ' class="active"' : '') !!} class="firstnav">
                                    <a href="{{ route('view-assets') }}">
                                        <x-icon type="dashboard" class="fa-fw" />
                                        <span>Dashboard</span>
                                    </a>
                                </li>
                            @endcan
                        @endif

                        {{-- ==================================================== --}}
                        {{-- BATAS MODIFIKASI --}}
                        {{-- ==================================================== --}}


                        @can('index', \App\Models\Asset::class)
                            <li class="treeview{{ ((request()->is('statuslabels/*') || request()->is('hardware*')) ? ' active' : '') }}">
                                <a href="#">
                                    <x-icon type="assets" class="fa-fw" />
                                    <span>{{ trans('general.assets') }}</span>
                                    <x-icon type="angle-left" class="pull-right fa-fw"/>
                                </a>
                                <ul class="treeview-menu">
                                    <li>
                                        <a href="{{ url('hardware') }}">
                                            <x-icon type="circle" class="text-grey fa-fw"/>
                                            {{ trans('general.list_all') }}
                                            <span class="badge">
                                                {{ (isset($total_assets)) ? $total_assets : '' }}
                                            </span>
                                        </a>
                                    </li>

                                    <?php $status_navs = \App\Models\Statuslabel::where('show_in_nav', '=', 1)->withCount('assets as asset_count')->get(); ?>
                                    @if (count($status_navs) > 0)
                                        @foreach ($status_navs as $status_nav)
                                            <li{!! (request()->is('statuslabels/'.$status_nav->id) ? ' class="active"' : '') !!}>
                                                <a href="{{ route('statuslabels.show', ['statuslabel' => $status_nav->id]) }}">
                                                    <i class="fas fa-circle text-grey fa-fw"
                                                       aria-hidden="true"{!!  ($status_nav->color!='' ? ' style="color: '.e($status_nav->color).'"' : '') !!}></i>
                                                    {{ $status_nav->name }}
                                                    <span class="badge badge-secondary">{{ $status_nav->asset_count }}</span></a></li>
                                        @endforeach
                                    @endif


                                    <li id="deployed-sidenav-option" {!! (Request::query('status') == 'Deployed' ? ' class="active"' : '') !!}>
                                        <a href="{{ url('hardware?status=Deployed') }}">
                                            <x-icon type="circle" class="text-blue fa-fw" />
                                            {{ trans('general.deployed') }}
                                            <span class="badge">{{ (isset($total_deployed_sidebar)) ? $total_deployed_sidebar : '' }}</span>
                                        </a>
                                    </li>
                                    <li id="rtd-sidenav-option"{!! (Request::query('status') == 'RTD' ? ' class="active"' : '') !!}>
                                        <a href="{{ url('hardware?status=RTD') }}">
                                            <x-icon type="circle" class="text-green fa-fw" />
                                            {{ trans('general.ready_to_deploy') }}
                                            <span class="badge">{{ (isset($total_rtd_sidebar)) ? $total_rtd_sidebar : '' }}</span>
                                        </a>
                                    </li>
                                    <li id="pending-sidenav-option"{!! (Request::query('status') == 'Pending' ? ' class="active"' : '') !!}><a href="{{ url('hardware?status=Pending') }}">
                                            <x-icon type="circle" class="text-orange fa-fw" />
                                            {{ trans('general.pending') }}
                                            <span class="badge">{{ (isset($total_pending_sidebar)) ? $total_pending_sidebar : '' }}</span>
                                        </a>
                                    </li>
                                    <li id="undeployable-sidenav-option"{!! (Request::query('status') == 'Undeployable' ? ' class="active"' : '') !!} ><a
                                                href="{{ url('hardware?status=Undeployable') }}">
                                            <x-icon type="x" class="text-red fa-fw" />
                                            {{ trans('general.undeployable') }}
                                            <span class="badge">{{ (isset($total_undeployable_sidebar)) ? $total_undeployable_sidebar : '' }}</span>
                                        </a>
                                    </li>
                                    <li id="byod-sidenav-option"{!! (Request::query('status') == 'byod' ? ' class="active"' : '') !!}><a
                                                href="{{ url('hardware?status=byod') }}">
                                            <x-icon type="x" class="text-red fa-fw" />
                                            {{ trans('general.byod') }}
                                            <span class="badge">{{ (isset($total_byod_sidebar)) ? $total_byod_sidebar : '' }}</span>
                                        </a>
                                    </li>
                                    <li id="archived-sidenav-option"{!! (Request::query('status') == 'Archived' ? ' class="active"' : '') !!}><a
                                                href="{{ url('hardware?status=Archived') }}">
                                            <x-icon type="x" class="text-red fa-fw" />
                                            {{ trans('admin/hardware/general.archived') }}
                                            <span class="badge">{{ (isset($total_archived_sidebar)) ? $total_archived_sidebar : '' }}</span>
                                        </a>
                                    </li>
                                    <li id="requestable-sidenav-option"{!! (Request::query('status') == 'Requestable' ? ' class="active"' : '') !!}><a
                                                href="{{ url('hardware?status=Requestable') }}">
                                            <x-icon type="checkmark" class="text-blue fa-fw" />
                                            {{ trans('admin/hardware/general.requestable') }}
                                        </a>
                                    </li>

                                    @can('audit', \App\Models\Asset::class)
                                        <li id="audit-due-sidenav-option"{!! (request()->is('hardware/audit/due') ? ' class="active"' : '') !!}>
                                            <a href="{{ route('assets.audit.due') }}">
                                                <x-icon type="audit" class="text-yellow fa-fw"/>
                                                {{ trans('general.audit_due') }}
                                                <span class="badge">{{ (isset($total_due_and_overdue_for_audit)) ? $total_due_and_overdue_for_audit : '' }}</span>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('checkin', \App\Models\Asset::class)
                                    <li id="checkin-due-sidenav-option"{!! (request()->is('hardware/checkins/due') ? ' class="active"' : '') !!}>
                                        <a href="{{ route('assets.checkins.due') }}">
                                            <x-icon type="due" class="text-orange fa-fw"/>
                                            {{ trans('general.checkin_due') }}
                                            <span class="badge">{{ (isset($total_due_and_overdue_for_checkin)) ? $total_due_and_overdue_for_checkin : '' }}</span>
                                        </a>
                                    </li>
                                    @endcan

                                    <li class="divider">&nbsp;</li>
                                    @can('checkin', \App\Models\Asset::class)
                                        <li{!! (request()->is('hardware/quickscancheckin') ? ' class="active"' : '') !!}>
                                            <a href="{{ route('hardware/quickscancheckin') }}">
                                                {{ trans('general.quickscan_checkin') }}
                                            </a>
                                        </li>
                                    @endcan

                                    @can('checkout', \App\Models\Asset::class)
                                        <li{!! (request()->is('hardware/bulkcheckout') ? ' class="active"' : '') !!}>
                                            <a href="{{ route('hardware.bulkcheckout.show') }}">
                                                {{ trans('general.bulk_checkout') }}
                                            </a>
                                        </li>
                                        <li{!! (request()->is('hardware/requested') ? ' class="active"' : '') !!}>
                                            <a href="{{ route('assets.requested') }}">
                                                {{ trans('general.requested') }}</a>
                                        </li>
                                    @endcan

                                    @can('create', \App\Models\Asset::class)
                                        <li{!! (Request::query('Deleted') ? ' class="active"' : '') !!}>
                                            <a href="{{ url('hardware?status=Deleted') }}">
                                                {{ trans('general.deleted') }}
                                            </a>
                                        </li>
                                        <li {!! (request()->is('maintenances') ? ' class="active"' : '') !!}>
                                            <a href="{{ route('maintenances.index') }}">
                                                {{ trans('general.maintenances') }}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('admin')
                                        <li id="import-history-sidenav-option" {!! (request()->is('hardware/history') ? ' class="active"' : '') !!}>
                                            <a href="{{ url('hardware/history') }}">
                                                {{ trans('general.import-history') }}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('audit', \App\Models\Asset::class)
                                        <li id="bulk-audit-sidenav-option" {!! (request()->is('hardware/bulkaudit') ? ' class="active"' : '') !!}>
                                            <a href="{{ route('assets.bulkaudit') }}">
                                                {{ trans('general.bulkaudit') }}
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        @endcan
                        @can('view', \App\Models\License::class)
                            <li{!! (request()->is('licenses*') ? ' class="active"' : '') !!}>
                                <a href="{{ route('licenses.index') }}">
                                    <x-icon type="licenses" class="fa-fw"/>
                                    <span>{{ trans('general.licenses') }}</span>
                                </a>
                            </li>
                        @endcan
                        @can('index', \App\Models\Accessory::class)
                            <li id="accessories-sidenav-option"{!! (request()->is('accessories*') ? ' class="active"' : '') !!}>
                                <a href="{{ route('accessories.index') }}">
                                    <x-icon type="accessories" class="fa-fw" />
                                    <span>{{ trans('general.accessories') }}</span>
                                </a>
                            </li>
                        @endcan
                        @can('view', \App\Models\Consumable::class)
                            <li id="consumables-sidenav-option"{!! (request()->is('consumables*') ? ' class="active"' : '') !!}>
                                <a href="{{ url('consumables') }}">
                                    <x-icon type="consumables" class="fa-fw" />
                                    <span>{{ trans('general.consumables') }}</span>
                                </a>
                            </li>
                        @endcan
                        @can('view', \App\Models\Component::class)
                            <li id="components-sidenav-option"{!! (request()->is('components*') ? ' class="active"' : '') !!}>
                                <a href="{{ route('components.index') }}">
                                    <x-icon type="components" class="fa-fw" />
                                    <span>{{ trans('general.components') }}</span>
                                </a>
                            </li>
                        @endcan
                        @can('view', \App\Models\PredefinedKit::class)
                            <li id="kits-sidenav-option"{!! (request()->is('kits') ? ' class="active"' : '') !!}>
                                <a href="{{ route('kits.index') }}">
                                    <x-icon type="kits" class="fa-fw" />
                                    <span>{{ trans('general.kits') }}</span>
                                </a>
                            </li>
                        @endcan

                        @can('view', \App\Models\User::class)
                                <li class="treeview{{ (request()->is('users*') ? ' active' : '') }}" id="users-sidenav-option">
                                    <a href="#" {{$snipeSettings->shortcuts_enabled == 1 ? "accesskey=6" : ''}}>
                                        <x-icon type="users" class="fa-fw" />
                                        <span>{{ trans('general.people') }}</span>
                                        <x-icon type="angle-left" class="pull-right fa-fw"/>
                                    </a>

                                    <ul class="treeview-menu">
                                        <li {!! ((request()->is('users')  && (request()->input() == null)) ? ' class="active"' : '') !!} id="users-sidenav-list-all">
                                            <a href="{{ route('users.index') }}">
                                                <x-icon type="circle" class="text-grey fa-fw fa-fw"/>
                                                {{ trans('general.list_all') }}
                                            </a>
                                        </li>
                                        <li class="{{ (request()->is('users') && request()->input('superadmins') == "true") ? 'active' : '' }}" id="users-sidenav-superadmins">
                                            <a href="{{ route('users.index', ['superadmins' => 'true']) }}">
                                                <x-icon type="superadmin" class="text-danger fa-fw"/>
                                                {{ trans('general.show_superadmins') }}
                                            </a>
                                        </li>
                                        <li class="{{ (request()->is('users') && request()->input('admins') == "true") ? 'active' : '' }}" id="users-sidenav-list-admins">
                                            <a href="{{ route('users.index', ['admins' => 'true']) }}">
                                                <x-icon type="admin" class="text-warning fa-fw"/>
                                                {{ trans('general.show_admins') }}
                                            </a>
                                        </li>
                                        <li class="{{ (request()->is('users') && request()->input('status') == "deleted") ? 'active' : '' }}" id="users-sidenav-deleted">
                                            <a href="{{ route('users.index', ['status' => 'deleted']) }}">
                                                <x-icon type="x" class="text-danger fa-fw"/>
                                                {{ trans('general.deleted_users') }}
                                            </a>
                                        </li>
                                        <li class="{{ (request()->is('users') && request()->input('activated') == "1") ? 'active' : '' }}" id="users-sidenav-activated">
                                            <a href="{{ route('users.index', ['activated' => true]) }}">
                                                <i class="fa-solid fa-person-circle-check text-success fa-fw"></i>
                                                {{ trans('general.login_enabled') }}
                                            </a>
                                        </li>
                                        <li class="{{ (request()->is('users') && request()->input('activated') == "0") ? 'active' : '' }}" id="users-sidenav-not-activated">
                                            <a href="{{ route('users.index', ['activated' => false]) }}">
                                                <i class="fa-solid fa-person-circle-xmark text-danger fa-fw"></i>
                                                {{ trans('general.login_disabled') }}
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                        @endcan
                        @can('import')
                            <li id="import-sidenav-option"{!! (request()->is('import*') ? ' class="active"' : '') !!}>
                                <a href="{{ route('imports.index') }}">
                                    <x-icon type="import" class="fa-fw" />
                                    <span>{{ trans('general.import') }}</span>
                                </a>
                            </li>
                        @endcan

                        @can('backend.interact')
                            <li id="settings-sidenav-option" class="treeview {!! in_array(Request::route()->getName(),App\Helpers\Helper::SettingUrls()) ? ' active': '' !!}">
                                <a href="#" id="settings">
                                    <x-icon type="settings" class="fa-fw" />
                                    <span>{{ trans('general.settings') }}</span>
                                    <x-icon type="angle-left" class="pull-right fa-fw"/>
                                </a>

                                <ul class="treeview-menu">
                                    @if(Gate::allows('view', App\Models\CustomField::class) || Gate::allows('view', App\Models\CustomFieldset::class))
                                        <li {!! (request()->is('fields*') ? ' class="active"' : '') !!}>
                                            <a href="{{ route('fields.index') }}">
                                                {{ trans('admin/custom_fields/general.custom_fields') }}
                                            </a>
                                        </li>
                                    @endif

                                    @can('view', \App\Models\Statuslabel::class)
                                        <li {!! (request()->is('statuslabels*') ? ' class="active"' : '') !!}>
                                            <a href="{{ route('statuslabels.index') }}">
                                                {{ trans('general.status_labels') }}
                                            </a>
                                        </li>
                                    @endcan

                                    @can('view', \App\Models\AssetModel::class)
                                        <li {{!! (request()->is('models') ? ' class="active"' : '') !!}}>
                                            <a href="{{ route('models.index') }}">
                                                {{ trans('general.asset_models') }}
                                            </a>
                                        </li>
                                    @endcan

                                    @can('view', \App\Models\Category::class)
                                        <li {{!! (request()->is('categories') ? ' class="active"' : '') !!}}>
                                            <a href="{{ route('categories.index') }}">
                                                {{ trans('general.categories') }}
                                            </a>
                                        </li>
                                    @endcan

                                    @can('view', \App\Models\Manufacturer::class)
                                        <li {{!! (request()->is('manufacturers') ? ' class="active"' : '') !!}}>
                                            <a href="{{ route('manufacturers.index') }}">
                                                {{ trans('general.manufacturers') }}
                                            </a>
                                        </li>
                                    @endcan

                                    @can('view', \App\Models\Supplier::class)
                                        <li {{!! (request()->is('suppliers') ? ' class="active"' : '') !!}}>
                                            <a href="{{ route('suppliers.index') }}">
                                                {{ trans('general.suppliers') }}
                                            </a>
                                        </li>
                                    @endcan

                                    @can('view', \App\Models\Department::class)
                                        <li {{!! (request()->is('departments') ? ' class="active"' : '') !!}}>
                                            <a href="{{ route('departments.index') }}">
                                                {{ trans('general.departments') }}
                                            </a>
                                        </li>
                                    @endcan

                                    @can('view', \App\Models\Location::class)
                                        <li {{!! (request()->is('locations') ? ' class="active"' : '') !!}}>
                                            <a href="{{ route('locations.index') }}">
                                                {{ trans('general.locations') }}
                                            </a>
                                        </li>
                                    @endcan

                                    @can('view', \App\Models\Company::class)
                                        <li {{!! (request()->is('companies') ? ' class="active"' : '') !!}}>
                                            <a href="{{ route('companies.index') }}">
                                                {{ trans('general.companies') }}
                                            </a>
                                        </li>
                                    @endcan

                                    @can('view', \App\Models\Depreciation::class)
                                        <li  {{!! (request()->is('depreciations') ? ' class="active"' : '') !!}}>
                                            <a href="{{ route('depreciations.index') }}">
                                                {{ trans('general.depreciation') }}
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        @endcan
{{-- MENU TIKETING TETAP ADA --}}
                        @if(Auth::check())
                        <li class="treeview{{ (request()->is('tickets*') ? ' active' : '') }}">
                            <a href="#">
                                <i class="fa fa-ticket fa-fw"></i>
                                <span>Ticketing</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li {!! (request()->is('tickets/create') ? 'class="active"' : '') !!}>
                                    <a href="{{ route('tickets.create') }}">
                                        <i class="fa fa-plus-circle fa-fw"></i>
                                        Buat Pengajuan
                                    </a>
                                </li>
                                <li {!! (request()->is('tickets/my-tickets') ? 'class="active"' : '') !!}>
                                    <a href="{{ route('tickets.my') }}">
                                        <i class="fa fa-list-ul fa-fw"></i>
                                        Riwayat Saya
                                    </a>
                                </li>

                                {{-- Menu Admin Only --}}
                                @if(Auth::user()->isSuperUser() || Auth::user()->hasAccess('admin'))
                                <li class="divider"></li>
                                <li {!! (request()->is('tickets/manage') ? 'class="active"' : '') !!}>
                                    <a href="{{ route('tickets.manage') }}">
                                        <i class="fa fa-wrench fa-fw text-orange"></i>
                                        Kelola Tiket (Admin)
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </li>
                        @endif
                        
                        @can('reports.view')
                            <li class="treeview{{ (request()->is('reports*') ? ' active' : '') }}">
                                <a href="#" class="dropdown-toggle">
                                    <x-icon type="reports" class="fa-fw" />
                                    <span>{{ trans('general.reports') }}</span>
                                    <x-icon type="angle-left" class="pull-right"/>
                                </a>

                                <ul class="treeview-menu">
                                    <li {{!! (request()->is('reports/activity') ? ' class="active"' : '') !!}}>
                                        <a href="{{ route('reports.activity') }}">
                                            {{ trans('general.activity_report') }}
                                        </a>
                                    </li>
                                    <li {{!! (request()->is('reports/custom') ? ' class="active"' : '') !!}}>
                                        <a href="{{ url('reports/custom') }}">
                                            {{ trans('general.custom_report') }}
                                        </a>
                                    </li>
                                    <li {{!! (request()->is('reports/audit') ? ' class="active"' : '') !!}}>
                                        <a href="{{ route('reports.audit') }}">
                                            {{ trans('general.audit_report') }}</a>
                                    </li>
                                    <li {{!! (request()->is('reports/depreciation') ? ' class="active"' : '') !!}}>
                                        <a href="{{ url('reports/depreciation') }}">
                                            {{ trans('general.depreciation_report') }}
                                        </a>
                                    </li>
                                    <li {{!! (request()->is('reports/licenses') ? ' class="active"' : '') !!}}>
                                        <a href="{{ url('reports/licenses') }}">
                                            {{ trans('general.license_report') }}
                                        </a>
                                    </li>
                                    <li {{!! (request()->is('ui.reports.maintenances') ? ' class="active"' : '') !!}}>
                                        <a href="{{ route('ui.reports.maintenances') }}">
                                            {{ trans('general.asset_maintenance_report') }}
                                        </a>
                                    </li>
                                    <li {{!! (request()->is('reports/unaccepted_assets') ? ' class="active"' : '') !!}}>
                                        <a href="{{ url('reports/unaccepted_assets') }}">
                                            {{ trans('general.unaccepted_asset_report') }}
                                        </a>
                                    </li>
                                    <li  {{!! (request()->is('reports/accessories') ? ' class="active"' : '') !!}}>
                                        <a href="{{ url('reports/accessories') }}">
                                            {{ trans('general.accessory_report') }}
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endcan

                        @can('viewRequestable', \App\Models\Asset::class)
                            <li{!! (request()->is('account/requestable-assets') ? ' class="active"' : '') !!}>
                                <a href="{{ route('requestable-assets') }}">
                                    <x-icon type="requestable" class="fa-fw" />
                                    <span>{{ trans('general.requestable_items') }}</span>
                                </a>
                            </li>
                        @endcan


                    </ul>
                </section>
                </aside>

            <div class="content-wrapper" role="main" id="setting-list">

                @if ($debug_in_production)
                    <div class="row" style="margin-bottom: 0px; background-color: red; color: white; font-size: 15px;">
                        <div class="col-md-12"
                             style="margin-bottom: 0px; background-color: #b50408 ; color: white; padding: 10px 20px 10px 30px; font-size: 16px;">
                            <x-icon type="warning" class="fa-3x pull-left"/>
                            <strong>{{ strtoupper(trans('general.debug_warning')) }}:</strong>
                            {!! trans('general.debug_warning_text') !!}
                        </div>
                    </div>
                @endif

                <section class="content-header">


                    <div class="row">
                        <div class="col-md-12" style="margin-bottom: 0px;">

                        <style>
                            .breadcrumb-item {
                                display: inline;
                                list-style: none;
                            }
                        </style>

                            <h1 class="pull-left pagetitle" style="font-size: 22px; margin-top: 5px;">

                                @if (Breadcrumbs::has() && (Breadcrumbs::current()->count() > 1))
                                    <ul style="padding-left: 0;">

                                    @foreach (Breadcrumbs::current() as $crumbs)
                                        @if ($crumbs->url() && !$loop->last)
                                            <li class="breadcrumb-item">
                                                <a href="{{ $crumbs->url() }}">
                                                    @if ($loop->first)
                                                        <x-icon type="home" />
                                                    @else
                                                        {{ $crumbs->title() }}
                                                    @endif
                                                </a>
                                                <x-icon type="angle-right" />
                                            </li>
                                        @elseif (is_null($crumbs->url()) && !$loop->last)
                                            <li class="breadcrumb-item active">
                                                {{ $crumbs->title() }}
                                                <x-icon type="angle-right" />
                                            </li>
                                       @else
                                            <li class="breadcrumb-item active">
                                                {{ $crumbs->title() }}
                                            </li>
                                        @endif
                                    @endforeach

                                    </ul>
                                @else
                                    @yield('title')
                                @endif

                            </h1>

                                @if (isset($helpText))
                                    @include ('partials.more-info',
                                                           [
                                                               'helpText' => $helpText,
                                                               'helpPosition' => (isset($helpPosition)) ? $helpPosition : 'left'
                                                           ])
                                @endif
                                <div class="pull-right">
                                    @yield('header_right')
                                </div>

                        </div>
                    </div>
                </section>


                <section class="content" id="main" tabindex="-1" style="padding-top: 0px;">

                    <div class="row">
                        @if (config('app.lock_passwords'))
                            <div class="col-md-12">
                                <div class="callout callout-info">
                                    {{ trans('general.some_features_disabled') }}
                                </div>
                            </div>
                        @endif

                        @include('notifications')
                    </div>


                    <div id="{!! (request()->is('*api*') ? 'app' : 'webui') !!}">
                        @yield('content')
                    </div>

                </section>

            </div><footer class="main-footer hidden-print" style="display:grid;flex-direction:column;">

                <div class="1hidden-xs pull-left">
                    <div class="pull-left">
                         {!! trans('general.footer_credit') !!}
                    </div>
                    <div class="pull-right">
                    @if ($snipeSettings->version_footer!='off')
                        @if (($snipeSettings->version_footer=='on') || (($snipeSettings->version_footer=='admin') && (Auth::user()->isSuperUser()=='1')))
                            &nbsp; <strong>{{ trans('general.version') }}</strong> {{ config('version.app_version') }} -
                            {{ trans('general.build') }} {{ config('version.build_version') }} ({{ config('version.branch') }})
                        @endif
                    @endif

                    @if (isset($user) && ($user->isSuperUser()) && (app()->environment('local')))
                       <a href="{{ url('telescope') }}" class="btn btn-default btn-xs" rel="noopener">Open Telescope</a>
                    @endif




                    @if ($snipeSettings->support_footer!='off')
                        @if (($snipeSettings->support_footer=='on') || (($snipeSettings->support_footer=='admin') && (Auth::user()->isSuperUser()=='1')))
                            <a target="_blank" class="btn btn-default btn-xs"
                               href="https://snipe-it.readme.io/docs/overview"
                               rel="noopener">{{ trans('general.user_manual') }}</a>
                            <a target="_blank" class="btn btn-default btn-xs" href="https://snipeitapp.com/support/"
                               rel="noopener">{{ trans('general.bug_report') }}</a>
                        @endif
                    @endif

                    @if ($snipeSettings->privacy_policy_link!='')
                        <a target="_blank" class="btn btn-default btn-xs" rel="noopener"
                           href="{{  $snipeSettings->privacy_policy_link }}"
                           target="_new">{{ trans('admin/settings/general.privacy_policy') }}</a>
                    @endif
                    </div>
                    <br>
                    @if ($snipeSettings->footer_text!='')
                        <div class="pull-left">
                            {!!  Helper::parseEscapedMarkedown($snipeSettings->footer_text)  !!}
                        </div>
                    @endif
                </div>
            </footer>
        </div><div class="modal modal-danger fade" id="dataConfirmModal" tabindex="-1" role="dialog" aria-labelledby="dataConfirmModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h2 class="modal-title" id="dataConfirmModalLabel">
                            <span class="modal-header-icon"></span>&nbsp;
                        </h2>
                    </div>
                    <div class="modal-body"></div>
                    <div class="modal-footer">
                        <form method="post" id="deleteForm" role="form" action="">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}

                            <button type="button" class="btn btn-default pull-left"
                                    data-dismiss="modal">{{ trans('general.cancel') }}</button>
                            <button type="submit" class="btn btn-outline"
                                    id="dataConfirmOK">{{ trans('general.yes') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal modal-warning fade" id="restoreConfirmModal" tabindex="-1" role="dialog"
             aria-labelledby="confirmModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="confirmModalLabel">&nbsp;</h4>
                    </div>
                    <div class="modal-body"></div>
                    <div class="modal-footer">
                        <form method="post" id="restoreForm" role="form">
                            {{ csrf_field() }}
                            {{ method_field('POST') }}

                            <button type="button" class="btn btn-default pull-left"
                                    data-dismiss="modal">{{ trans('general.cancel') }}</button>
                            <button type="submit" class="btn btn-outline"
                                    id="dataConfirmOK">{{ trans('general.yes') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>



        {{-- Javascript files --}}
        <script src="{{ url(mix('js/dist/all.js')) }}" nonce="{{ csrf_token() }}"></script>
        <script src="{{ url('js/select2/i18n/'.Helper::mapBackToLegacyLocale(app()->getLocale()).'.js') }}"></script>

        {{-- Page level javascript --}}
        @stack('js')

        @section('moar_scripts')
        @show


        <script nonce="{{ csrf_token() }}">

            //color picker with addon
            $("#color").colorpicker();


            $.fn.datepicker.dates['{{ app()->getLocale() }}'] = {
                days: [
                    "{{ trans('datepicker.days.sunday') }}",
                    "{{ trans('datepicker.days.monday') }}",
                    "{{ trans('datepicker.days.tuesday') }}",
                    "{{ trans('datepicker.days.wednesday') }}",
                    "{{ trans('datepicker.days.thursday') }}",
                    "{{ trans('datepicker.days.friday') }}",
                    "{{ trans('datepicker.days.saturday') }}"
                ],
                daysShort: [
                    "{{ trans('datepicker.short_days.sunday') }}",
                    "{{ trans('datepicker.short_days.monday') }}",
                    "{{ trans('datepicker.short_days.tuesday') }}",
                    "{{ trans('datepicker.short_days.wednesday') }}",
                    "{{ trans('datepicker.short_days.thursday') }}",
                    "{{ trans('datepicker.short_days.friday') }}",
                    "{{ trans('datepicker.short_days.saturday') }}"
                ],
                daysMin: [
                    "{{ trans('datepicker.min_days.sunday') }}",
                    "{{ trans('datepicker.min_days.monday') }}",
                    "{{ trans('datepicker.min_days.tuesday') }}",
                    "{{ trans('datepicker.min_days.wednesday') }}",
                    "{{ trans('datepicker.min_days.thursday') }}",
                    "{{ trans('datepicker.min_days.friday') }}",
                    "{{ trans('datepicker.min_days.saturday') }}"
                ],
                months: [
                    "{{ trans('datepicker.months.january') }}",
                    "{{ trans('datepicker.months.february') }}",
                    "{{ trans('datepicker.months.march') }}",
                    "{{ trans('datepicker.months.april') }}",
                    "{{ trans('datepicker.months.may') }}",
                    "{{ trans('datepicker.months.june') }}",
                    "{{ trans('datepicker.months.july') }}",
                    "{{ trans('datepicker.months.august') }}",
                    "{{ trans('datepicker.months.september') }}",
                    "{{ trans('datepicker.months.october') }}",
                    "{{ trans('datepicker.months.november') }}",
                    "{{ trans('datepicker.months.december') }}",
                ],
                monthsShort:  [
                    "{{ trans('datepicker.months_short.january') }}",
                    "{{ trans('datepicker.months_short.february') }}",
                    "{{ trans('datepicker.months_short.march') }}",
                    "{{ trans('datepicker.months_short.april') }}",
                    "{{ trans('datepicker.months_short.may') }}",
                    "{{ trans('datepicker.months_short.june') }}",
                    "{{ trans('datepicker.months_short.july') }}",
                    "{{ trans('datepicker.months_short.august') }}",
                    "{{ trans('datepicker.months_short.september') }}",
                    "{{ trans('datepicker.months_short.october') }}",
                    "{{ trans('datepicker.months_short.november') }}",
                    "{{ trans('datepicker.months_short.december') }}",
                ],
                today: "{{ trans('datepicker.today') }}",
                clear: "{{ trans('datepicker.clear') }}",
                format: "yyyy-mm-dd",
                weekStart: {{ $snipeSettings->week_start ?? 0 }},
            };

            var clipboard = new ClipboardJS('.js-copy-link');

            clipboard.on('success', function(e) {
                e.text = e.text.replace(/^\s/, '').trim();
                var clickedElement = $(e.trigger);
                clickedElement.tooltip('hide').attr('data-original-title', '{{ trans('general.copied') }}').tooltip('show');
            });


            // Reference: https://jqueryvalidation.org/validate/
            var validator = $('#create-form').validate({
                ignore: 'input[type=hidden]',
                errorClass: 'alert-msg',
                errorElement: 'div',
                errorPlacement: function(error, element) {

                    if ($(element).hasClass('select2') || $(element).hasClass('js-data-ajax')) {
                        // If the element is a select2 then append the error to the parent div
                        element.parent('div').append(error);

                     } else if ($(element).parent().hasClass('input-group')) {
                        var end_input_group = $(element).next('.input-group-addon').parent();
                        error.insertAfter(end_input_group);
                    } else {
                        error.insertAfter(element);
                    }

                },
                highlight: function(inputElement) {

                    // We have to go two levels up if it's an input group
                    if ($(inputElement).parent().hasClass('input-group')) {
                        $(inputElement).parent().parent().parent().addClass('has-error');
                    } else {
                        $(inputElement).parent().addClass('has-error');
                        $(inputElement).closest('.help-block').remove();
                    }

                },
                onfocusout: function(element) {
                    // We have to go two levels up if it's an input group
                    if ($(element).parent().hasClass('input-group')) {
                        $(element).parent().parent().parent().removeClass('has-error');
                        return $(element).valid();
                    } else {
                        $(element).parent().removeClass('has-error');
                        return $(element).valid();
                    }

                },

            });

            $.extend($.validator.messages, {
                required: "{{ trans('validation.generic.required') }}",
                email: "{{ trans('validation.generic.email') }}"
            });


            function showHideEncValue(e) {
                // Use element id to find the text element to hide / show
                var targetElement = e.id+"-to-show";
                var hiddenElement = e.id+"-to-hide";
                var audio = new Audio('{{ config('app.url') }}/sounds/lock.mp3');
                if($(e).hasClass('fa-lock')) {
                    @if ((isset($user)) && ($user->enable_sounds))
                        audio.play()
                    @endif
                    $(e).removeClass('fa-lock').addClass('fa-unlock');
                    // Show the encrypted custom value and hide the element with asterisks
                    document.getElementById(targetElement).style.fontSize = "100%";
                    document.getElementById(hiddenElement).style.display = "none";

                } else {
                    @if ((isset($user)) && ($user->enable_sounds))
                        audio.play()
                    @endif
                    $(e).removeClass('fa-unlock').addClass('fa-lock');
                    // ClipboardJS can't copy display:none elements so use a trick to hide the value
                    document.getElementById(targetElement).style.fontSize = "0px";
                    document.getElementById(hiddenElement).style.display = "";

                 }
             }

            $(function () {

                // This handles the show/hide for cloned items
                $('#use_cloned_image').click(function() {
                    if ($('#use_cloned_image').is(':checked')) {
                        $('#image_delete').prop('checked', false);
                        $('#image-upload').hide();
                        $('#existing-image').show();
                    } else {
                        $('#image-upload').show();
                        $('#existing-image').hide();
                    }
                    //$('#image-upload').hide();
                });

                // Invoke Bootstrap 3's tooltip
                $('[data-tooltip="true"]').tooltip({
                    container: 'body',
                    animation: true,
                });

                $('[data-toggle="popover"]').popover();
                $('.select2 span').addClass('needsclick');
                $('.select2 span').removeAttr('title');

                // This javascript handles saving the state of the menu (expanded or not)
                $('body').bind('expanded.pushMenu', function () {
                    $.ajax({
                        type: 'GET',
                        url: "{{ route('account.menuprefs', ['state'=>'open']) }}",
                        _token: "{{ csrf_token() }}"
                    });

                });

                $('body').bind('collapsed.pushMenu', function () {
                    $.ajax({
                        type: 'GET',
                        url: "{{ route('account.menuprefs', ['state'=>'close']) }}",
                        _token: "{{ csrf_token() }}"
                    });
                });

            });

            // Initiate the ekko lightbox
            $(document).on('click', '[data-toggle="lightbox"]', function (event) {
                event.preventDefault();
                $(this).ekkoLightbox();
            });
            //This prevents multi-click checkouts for accessories, components, consumables
            $(document).ready(function () {
                $('#checkout_form').submit(function (event) {
                    event.preventDefault();
                    $('#submit_button').prop('disabled', true);
                    this.submit();
                });
            });

            // Select encrypted custom fields to hide them in the asset list
            $(document).ready(function() {
                // Selector for elements with css-padlock class
                var selector = 'td.css-padlock';

                // Function to add original value to elements
                function addValue($element) {
                    // Get original value of the element
                    var originalValue = $element.text().trim();

                    // Show asterisks only for not empty values
                    if (originalValue !== '') {
                        // This is necessary to avoid loop because value is generated dynamically
                        if (originalValue !== '' && originalValue !== asterisks) $element.attr('value', originalValue);

                        // Hide the original value and show asterisks of the same length
                        var asterisks = '*'.repeat(originalValue.length);
                        $element.text(asterisks);

                        // Add click event to show original text
                        $element.click(function() {
                            var $this = $(this);
                            if ($this.text().trim() === asterisks) {
                                $this.text($this.attr('value'));
                            } else {
                                $this.text(asterisks);
                            }
                        });
                    }
                }
                // Add value to existing elements
                $(selector).each(function() {
                    addValue($(this));
                });

                // Function to handle mutations in the DOM because content is generated dynamically
                var observer = new MutationObserver(function(mutations) {
                    mutations.forEach(function(mutation) {
                        // Check if new nodes have been inserted
                        if (mutation.type === 'childList') {
                            mutation.addedNodes.forEach(function(node) {
                                if ($(node).is(selector)) {
                                    addValue($(node));
                                } else {
                                    $(node).find(selector).each(function() {
                                        addValue($(this));
                                    });
                                }
                            });
                        }
                    });
                });

                // Configure the observer to observe changes in the DOM
                var config = { childList: true, subtree: true };
                observer.observe(document.body, config);
            });


        </script>

        @if ((session()->get('topsearch')=='true') || (request()->is('/')))
            <script nonce="{{ csrf_token() }}">
                $("#tagSearch").focus();
            </script>
        @endif
<script>
    $(document).ready(function() {
        
        // 1. Animasi Tombol Submit
        // Setiap ada form yang dikirim (submit), cari tombol submit-nya
        $('form').on('submit', function() {
            var $btn = $(this).find('button[type="submit"], input[type="submit"]');
            
            // Cek jika form valid (jika pakai jquery validate)
            if ($(this).valid && !$(this).valid()) {
                return; 
            }

            // Tambahkan efek loading
            var originalText = $btn.html();
            $btn.addClass('btn-loading'); // Pakai CSS spinner di atas
            // Atau ganti teks manual:
            // $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Menyimpan...');
        });

        // 2. Animasi Klik Link Navigasi (Optional: Bar Loading di atas)
        // Jika Anda ingin efek seperti YouTube (garis merah jalan di atas)
        // Anda perlu library NProgress, tapi script CSS FadeInUp di atas sudah cukup bagus.
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        
        // ==========================================
        // 1. LOGIKA LOADING BAR (PINDAH HALAMAN)
        // ==========================================
        
        // Jalankan bar saat user meninggalkan halaman (klik link)
        $(window).on('beforeunload', function() {
            NProgress.start();
        });

        // Jalankan bar saat ada proses AJAX (pencarian, filter tabel, dll)
        $(document).ajaxStart(function() {
            NProgress.start();
        });
        $(document).ajaxStop(function() {
            NProgress.done();
        });


        // ==========================================
        // 2. LOGIKA POP-UP DIALOG (SAAT SUBMIT)
        // ==========================================

        // Tangkap semua form saat disubmit
        $('form').on('submit', function(e) {
            var form = this;
            
            // Cek validasi HTML5/jQuery Validate dulu
            if ($(this).valid && !$(this).valid()) {
                return; // Jika error, jangan munculkan popup
            }

            // Tampilkan Dialog Loading "Sedang Memproses"
            Swal.fire({
                title: 'Sedang Memproses...',
                text: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            // Biarkan form lanjut mengirim data ke server
        });


        // ==========================================
        // 3. LOGIKA NOTIFIKASI SUKSES/ERROR (SERVER)
        // ==========================================
        
        // Cek apakah Laravel mengirim session 'success'
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                timer: 3000,
                showConfirmButton: false
            });
        @endif

        // Cek apakah Laravel mengirim session 'error'
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: "{{ session('error') }}",
            });
        @endif
    }); 
</script>
        </body>
</html>
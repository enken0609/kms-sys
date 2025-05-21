<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <meta name="robots" content="noindex, nofollow">

  <title>{{ config('app.name', 'KMS') }}</title>

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Scripts -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
  <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
  <script src="{{ asset('js/app.js') }}" defer></script>

  <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @stack('scripts')
</head>

<body id="page-top">
  <div id="app">
    <main class="">
      <div id="wrapper">
        <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar shadow">
          <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
            <!-- <img src="{{ Vite::asset('resources/img/kms_logo.png') }}" width="80" height="47"
              class="d-inline-block align-top" alt=""> -->
          </a>
          <hr class="sidebar-divider my-0">
          <li class="nav-item active pl-2">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
          </li>
          <hr class="sidebar-divider">
          <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('admin.race.list') }}" data-toggle="collapse"
              data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
              <i class="fas fa-fw fa-cog"></i>
              <span>レース管理</span>
            </a>
          </li>
        </ul>
        <div id="content-wrapper" class="d-flex flex-column">
          <div id="content">
            <div class="container-fluid py-4">
              <div class="row">
                @yield('content')
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</body>

</html>

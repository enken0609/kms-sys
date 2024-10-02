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

  <link href="../../css/public.css" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Scripts -->

  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
  <link href="{{ asset('css/public.css') }}" rel="stylesheet">
  <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
  <script src="{{ asset('js/app.js') }}" defer></script>

  <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
</head>

<body id="page-top">
  <div id="app">
    <nav class="navbar navbar-light bg-white shadow">
      <a class="navbar-brand" href="/">
        <img src="{{ asset('img/kms_logo.png') }}" width="64" height="38" class="d-inline-block align-top" alt="">
      </a>
    </nav>
    <main class="">
      @yield('content')
    </main>
  </div>

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}" defer></script>
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <!-- Bootstrap JS -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>

</html>

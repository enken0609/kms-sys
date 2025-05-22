<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>KMS - ログイン</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @stack('scripts')
</head>

<body class="bg-gray-100">
  <div class="min-h-screen flex items-center justify-center">
    @yield('content')
  </div>
</body>

</html>

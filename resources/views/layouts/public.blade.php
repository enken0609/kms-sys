<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <meta name="robots" content="noindex, nofollow">

  <title>{{ config('app.name', 'KMS') }}</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700&display=swap" rel="stylesheet">

  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @stack('scripts')

  <style>
    :root {
      --primary-color: #2563eb;
      --secondary-color: #3b82f6;
      --accent-color: #60a5fa;
      --background-color: #f8fafc;
      --text-color: #1e293b;
    }
    
    body {
      font-family: 'Noto Sans JP', sans-serif;
      background-color: var(--background-color);
      color: var(--text-color);
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
    }

    .transition-all {
      transition: all 0.3s ease;
    }

    .hover-scale:hover {
      transform: scale(1.02);
    }

    .card {
      background: white;
      border-radius: 0.75rem;
      box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
      transition: all 0.3s ease;
    }

    .card:hover {
      box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
    }

    .btn-primary {
      background-color: var(--primary-color);
      color: white;
      padding: 0.5rem 1rem;
      border-radius: 0.5rem;
      transition: all 0.3s ease;
      font-weight: 500;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      min-width: 80px;
    }

    .btn-primary:hover {
      background-color: var(--secondary-color);
      transform: translateY(-1px);
    }

    .table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0;
      margin-bottom: 1rem;
    }

    .table th {
      background-color: var(--background-color);
      padding: 0.75rem 1rem;
      font-weight: 500;
      text-align: left;
      white-space: nowrap;
      border-bottom: 2px solid #e2e8f0;
    }

    .table td {
      padding: 0.75rem 1rem;
      border-bottom: 1px solid #e2e8f0;
      white-space: nowrap;
    }

    .table tr:hover {
      background-color: #f1f5f9;
    }

    @media (max-width: 640px) {
      .table-container {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
      }
      
      .table {
        min-width: 500px;
      }
    }
  </style>
</head>

<body class="min-h-screen">
  <div id="app" class="flex flex-col min-h-screen">
    <nav class="bg-white shadow-sm sticky top-0 z-50">
      <div class="container mx-auto px-4 py-3">
        <div class="flex justify-between items-center">
          <a class="flex items-center space-x-2" href="/">
            <img src="{{ asset('img/kms_logo.png') }}" width="48" height="48" class="object-contain" alt="KMS Logo">
            <span class="text-xl font-bold text-gray-800">KMS</span>
          </a>
        </div>
      </div>
    </nav>

    <main class="flex-grow container mx-auto px-4 py-8">
      @yield('content')
    </main>

    <footer class="bg-gray-800 text-white py-2 mt-auto">
      <div class="container mx-auto px-4">
        <div class="text-center">
          <p>&copy; {{ date('Y') }} KMS. All rights reserved.</p>
        </div>
      </div>
    </footer>
  </div>
</body>

</html>

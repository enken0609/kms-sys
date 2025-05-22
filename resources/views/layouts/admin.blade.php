<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KMS - 管理画面</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('scripts')
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- サイドバー -->
        <aside class="fixed inset-y-0 left-0 w-64 bg-white shadow-lg">
            <div class="flex items-center justify-center h-16 bg-blue-600">
                <h1 class="text-xl font-bold text-white">KMS 管理画面</h1>
            </div>
            <nav class="mt-6">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-100">
                    <i class="fas fa-home mr-3"></i>
                    ダッシュボード
                </a>
                <a href="{{ route('admin.races.index') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-100">
                    <i class="fas fa-flag mr-3"></i>
                    レース管理
                </a>
                <a href="{{ route('admin.categories.index') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-100">
                    <i class="fas fa-tags mr-3"></i>
                    カテゴリー管理
                </a>
                <a href="{{ route('admin.certificate-templates.index') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-100">
                    <i class="fas fa-certificate mr-3"></i>
                    記録証テンプレート
                </a>
                <form method="POST" action="{{ route('admin.logout') }}" class="mt-6">
                    @csrf
                    <button type="submit" class="flex items-center w-full px-6 py-3 text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-sign-out-alt mr-3"></i>
                        ログアウト
                    </button>
                </form>
            </nav>
        </aside>

        <!-- メインコンテンツ -->
        <main class="ml-64 p-8">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-800">@yield('title')</h2>
            </div>

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html> 
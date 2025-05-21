<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KMS - ログイン</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="max-w-md w-full">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800">KMS 管理画面</h1>
                <p class="mt-2 text-gray-600">ログインして管理画面にアクセス</p>
            </div>

            <div class="bg-white rounded-lg shadow-md p-8">
                <form method="POST" action="{{ route('admin.login') }}">
                    @csrf

                    <div class="mb-6">
                        <label for="email" class="form-label">メールアドレス</label>
                        <input type="email" id="email" name="email" class="form-input @error('email') border-red-500 @enderror" value="{{ old('email') }}" required autofocus>
                        @error('email')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="password" class="form-label">パスワード</label>
                        <input type="password" id="password" name="password" class="form-input @error('password') border-red-500 @enderror" required>
                        @error('password')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center">
                            <input type="checkbox" id="remember" name="remember" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                            <label for="remember" class="ml-2 block text-sm text-gray-700">ログイン状態を保持</label>
                        </div>
                    </div>

                    <button type="submit" class="w-full btn-primary">
                        ログイン
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html> 
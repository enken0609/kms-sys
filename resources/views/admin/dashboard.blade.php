@extends('layouts.admin')

@section('title', 'ダッシュボード')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- 最近のレース -->
    <div class="card">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800">最近のレース</h3>
            <a href="{{ route('admin.races.index') }}" class="text-primary-600 hover:text-primary-700">すべて見る</a>
        </div>
        <div class="space-y-4">
            @forelse($races as $race)
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div>
                        <h4 class="font-medium text-gray-800">{{ $race->name }}</h4>
                        <p class="text-sm text-gray-600">{{ $race->date->format('Y年m月d日') }}</p>
                    </div>
                    <a href="{{ route('admin.races.edit', $race) }}" class="btn-secondary text-sm">編集</a>
                </div>
            @empty
                <p class="text-gray-600">レースが登録されていません</p>
            @endforelse
        </div>
    </div>

    <!-- カテゴリー統計 -->
    <div class="card">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800">カテゴリー統計</h3>
            <a href="{{ route('admin.categories.index') }}" class="text-primary-600 hover:text-primary-700">すべて見る</a>
        </div>
        <div class="space-y-4">
            @forelse($categories as $category)
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div>
                        <h4 class="font-medium text-gray-800">{{ $category->name }}</h4>
                        <p class="text-sm text-gray-600">{{ $category->results_count }}件のリザルト</p>
                    </div>
                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn-secondary text-sm">編集</a>
                </div>
            @empty
                <p class="text-gray-600">カテゴリーが登録されていません</p>
            @endforelse
        </div>
    </div>
</div>

<!-- クイックアクション -->
<div class="mt-8">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">クイックアクション</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="{{ route('admin.races.create') }}" class="card hover:bg-gray-50 transition-colors">
            <div class="flex items-center">
                <i class="fas fa-plus-circle text-primary-600 text-2xl mr-3"></i>
                <div>
                    <h4 class="font-medium text-gray-800">新規レース登録</h4>
                    <p class="text-sm text-gray-600">新しいレースを登録します</p>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.categories.create') }}" class="card hover:bg-gray-50 transition-colors">
            <div class="flex items-center">
                <i class="fas fa-tag text-primary-600 text-2xl mr-3"></i>
                <div>
                    <h4 class="font-medium text-gray-800">新規カテゴリー登録</h4>
                    <p class="text-sm text-gray-600">新しいカテゴリーを登録します</p>
                </div>
            </div>
        </a>
    </div>
</div>
@endsection 
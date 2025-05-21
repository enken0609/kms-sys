@extends('layouts.admin')

@section('title', 'カテゴリー編集')

@section('content')
    <div class="bg-white rounded-lg shadow-lg p-6">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="race_id" class="block text-sm font-medium text-gray-700">所属レース</label>
                <select name="race_id" id="race_id" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">選択してください</option>
                    @foreach($races as $race)
                        <option value="{{ $race->id }}" {{ old('race_id', $category->race_id) == $race->id ? 'selected' : '' }}>
                            {{ $race->name }} ({{ $race->date->format('Y年m月d日') }})
                        </option>
                    @endforeach
                </select>
                @error('race_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">カテゴリー名</label>
                <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="display_order" class="block text-sm font-medium text-gray-700">表示順</label>
                <input type="number" name="display_order" id="display_order" value="{{ old('display_order', $category->display_order) }}" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                @error('display_order')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <div class="flex items-center">
                    <input type="checkbox" name="is_team_race" id="is_team_race" value="1" 
                        {{ old('is_team_race', $category->is_team_race) ? 'checked' : '' }}
                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="is_team_race" class="ml-2 block text-sm text-gray-900">
                        チームレース
                    </label>
                </div>
                @error('is_team_race')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.categories.index') }}" 
                    class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    キャンセル
                </a>
                <button type="submit" 
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                    更新する
                </button>
            </div>
        </form>
    </div>
@endsection 
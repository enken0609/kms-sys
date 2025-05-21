@extends('layouts.admin')

@section('title', 'カテゴリー管理')

@section('content')
    <div class="mb-4">
        <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            <i class="fas fa-plus mr-2"></i>新規カテゴリー登録
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">表示順</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">カテゴリー名</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">所属レース</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">チームレース</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">操作</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($categories as $category)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $category->display_order }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $category->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $category->race->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($category->is_team_race)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    はい
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                    いいえ
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <a href="{{ route('admin.categories.show', $category) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                <i class="fas fa-eye"></i> 詳細
                            </a>
                            <a href="{{ route('admin.categories.edit', $category) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                <i class="fas fa-edit"></i> 編集
                            </a>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('本当に削除しますか？');">
                                    <i class="fas fa-trash"></i> 削除
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $categories->links() }}
    </div>
@endsection 
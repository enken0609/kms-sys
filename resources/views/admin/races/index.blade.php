@extends('layouts.admin')

@section('title', 'レース管理')

@section('content')
    <div class="mb-4">
        <a href="{{ route('admin.races.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            <i class="fas fa-plus mr-2"></i>新規レース登録
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">レース名</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">シリーズ</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">開催日</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">説明</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">操作</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($races as $race)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $race->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $race->series_name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $race->date->format('Y年m月d日') }}</td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900 line-clamp-2">{{ $race->description }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <a href="{{ route('admin.races.edit', $race) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                <i class="fas fa-edit"></i> 編集
                            </a>
                            <form action="{{ route('admin.races.destroy', $race) }}" method="POST" class="inline">
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
        {{ $races->links() }}
    </div>
@endsection 
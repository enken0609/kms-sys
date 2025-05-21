@extends('layouts.admin')

@section('title', '記録証テンプレート管理')

@section('content')
    <!-- フラッシュメッセージ -->
    @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">記録証テンプレート一覧</h2>
            <a href="{{ route('admin.certificate-templates.create') }}" 
               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                新規テンプレート作成
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            プレビュー
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            テンプレート名
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            用紙サイズ
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            向き
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            作成日
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            操作
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($templates as $template)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <img src="{{ asset('uploads/' . $template->image_path) }}" 
                                     alt="{{ $template->name }}" 
                                     class="h-20 w-auto object-contain">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $template->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $template->paper_size }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $template->orientation === 'portrait' ? '縦' : '横' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $template->created_at->format('Y/m/d H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.certificate-templates.edit', $template) }}" 
                                   class="text-blue-600 hover:text-blue-900 mr-3">編集</a>
                                <form action="{{ route('admin.certificate-templates.destroy', $template) }}" 
                                      method="POST" 
                                      class="inline"
                                      onsubmit="return confirm('このテンプレートを削除してもよろしいですか？');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">削除</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $templates->links() }}
        </div>
    </div>
@endsection 
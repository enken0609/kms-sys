@extends('layouts.admin')

@section('title', 'カテゴリー詳細')

@section('content')
    <!-- フラッシュメッセージ -->
    @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-lg p-6">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800">{{ $category->name }}</h2>
            <p class="text-gray-600">{{ $category->race->name }}</p>
        </div>

        <div class="mb-8">
            <div class="flex items-center space-x-4">
                <span class="text-gray-600">表示順: {{ $category->display_order }}</span>
                <span class="text-gray-600">
                    チームレース:
                    @if($category->is_team_race)
                        <span class="text-green-600">はい</span>
                    @else
                        <span class="text-red-600">いいえ</span>
                    @endif
                </span>
            </div>
        </div>

        <!-- リザルトインポートフォーム -->
        <div class="mt-8 border-t pt-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">リザルトのインポート</h3>
                <a href="{{ route('admin.categories.csv-sample', $category) }}" 
                   class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    CSVサンプルをダウンロード
                </a>
            </div>
            
            <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-md">
                <h4 class="text-sm font-medium text-blue-800 mb-2">📋 CSVフォーマット説明</h4>
                <p class="text-sm text-blue-700 mb-2">以下の列順でCSVファイルを作成してください：</p>
                <div class="text-xs text-blue-600 grid grid-cols-3 gap-2">
                    <span>1. 総合順位</span>
                    <span>2. ゼッケン番号</span>
                    <span>3. 氏名</span>
                    <span>4. 性別</span>
                    <span>5. タイム</span>
                    <span>6. 年代別順位</span>
                    <span>7. チーム名 <small>(任意)</small></span>
                    <span>8. チーム順位 <small>(任意)</small></span>
                    <span>9. チームタイム <small>(任意)</small></span>
                </div>
                <p class="text-xs text-blue-600 mt-2">
                    <strong>注意:</strong> ファイルはUTF-8またはShift_JISエンコーディングで保存してください。
                </p>
            </div>

            <form action="{{ route('admin.categories.import', $category) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                
                <div class="mb-4">
                    <label for="block_id" class="block text-sm font-medium text-gray-700">ブロック選択</label>
                    <select name="block_id" id="block_id" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">選択してください</option>
                        @foreach($blocks as $block)
                            <option value="{{ $block->id }}">{{ $block->name }}</option>
                        @endforeach
                    </select>
                    @error('block_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="csv_file" class="block text-sm font-medium text-gray-700">CSVファイル</label>
                    <input type="file" name="csv_file" id="csv_file" required accept=".csv"
                        class="mt-1 block w-full text-sm text-gray-500
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-md file:border-0
                        file:text-sm file:font-semibold
                        file:bg-blue-50 file:text-blue-700
                        hover:file:bg-blue-100">
                    @error('csv_file')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="submit" 
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        インポート
                    </button>
                </div>
            </form>
        </div>

        <!-- インポート済みリザルト一覧 -->
        @if($results->count() > 0)
            <div class="mt-8 border-t pt-6">
                <h3 class="text-lg font-semibold mb-4">インポート済みリザルト</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ブロック</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">順位</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ビブ番号</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">名前</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">性別</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">タイム</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">年代別順位</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">チーム名</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($results as $result)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $result->block->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $result->place }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $result->bib }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $result->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($result->gender === 'Female')
                                            女子
                                        @elseif($result->gender === 'Male')
                                            男子
                                        @else
                                            {{ $result->gender }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $result->time }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $result->age_place }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $result->team_name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
@endsection 
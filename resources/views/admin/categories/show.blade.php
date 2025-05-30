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
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">インポート済みリザルト ({{ $results->count() }}件)</h3>
                    <div class="flex space-x-2">
                        <button onclick="selectAll()" class="text-sm px-3 py-1 bg-gray-100 text-gray-700 rounded hover:bg-gray-200">
                            全選択
                        </button>
                        <button onclick="deselectAll()" class="text-sm px-3 py-1 bg-gray-100 text-gray-700 rounded hover:bg-gray-200">
                            選択解除
                        </button>
                        <button onclick="bulkDelete()" class="text-sm px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600" disabled id="bulkDeleteBtn">
                            選択削除
                        </button>
                    </div>
                </div>
                
                <form id="bulkDeleteForm" action="{{ route('admin.categories.results.bulk-delete', $category) }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-12">
                                    <input type="checkbox" id="selectAllCheckbox" onchange="toggleAll(this)" class="rounded">
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ブロック</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">順位</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ビブ番号</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">名前</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">性別</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">タイム</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">年代別順位</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">チーム名</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-20">操作</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($results as $result)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="checkbox" name="result_checkbox" value="{{ $result->id }}" onchange="updateBulkDeleteButton()" class="rounded">
                                    </td>
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
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <form action="{{ route('admin.categories.results.delete', [$category, $result]) }}" method="POST" 
                                              onsubmit="return confirm('このリザルトを削除しますか？')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 text-sm">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <script>
                function toggleAll(selectAllCheckbox) {
                    const checkboxes = document.querySelectorAll('input[name="result_checkbox"]');
                    checkboxes.forEach(checkbox => {
                        checkbox.checked = selectAllCheckbox.checked;
                    });
                    updateBulkDeleteButton();
                }

                function selectAll() {
                    const selectAllCheckbox = document.getElementById('selectAllCheckbox');
                    selectAllCheckbox.checked = true;
                    toggleAll(selectAllCheckbox);
                }

                function deselectAll() {
                    const selectAllCheckbox = document.getElementById('selectAllCheckbox');
                    selectAllCheckbox.checked = false;
                    toggleAll(selectAllCheckbox);
                }

                function updateBulkDeleteButton() {
                    const checkboxes = document.querySelectorAll('input[name="result_checkbox"]:checked');
                    const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
                    const selectAllCheckbox = document.getElementById('selectAllCheckbox');
                    
                    bulkDeleteBtn.disabled = checkboxes.length === 0;
                    
                    // 全選択チェックボックスの状態を更新
                    const allCheckboxes = document.querySelectorAll('input[name="result_checkbox"]');
                    selectAllCheckbox.checked = allCheckboxes.length > 0 && checkboxes.length === allCheckboxes.length;
                }

                function bulkDelete() {
                    const checkboxes = document.querySelectorAll('input[name="result_checkbox"]:checked');
                    if (checkboxes.length === 0) {
                        alert('削除するリザルトを選択してください。');
                        return;
                    }

                    if (!confirm(`選択した${checkboxes.length}件のリザルトを削除しますか？`)) {
                        return;
                    }

                    const form = document.getElementById('bulkDeleteForm');
                    checkboxes.forEach(checkbox => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'result_ids[]';
                        input.value = checkbox.value;
                        form.appendChild(input);
                    });

                    form.submit();
                }
            </script>
        @endif
    </div>
@endsection 
@extends('layouts.public')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('public.races.category', $race->id) }}" class="inline-flex items-center text-xs text-gray-600 hover:text-gray-900">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            カテゴリー一覧に戻る
        </a>
    </div>

    <div class="mb-3">
        <h1 class="text-2xl font-bold text-gray-900">{{ $race->name }}</h1>
        <h2 class="mt-3 text-xl font-semibold text-gray-800">{{ $category->name }}</h2>
    </div>

    @foreach($results as $block_id => $blockResults)
    <div class="mb-8 bg-white">
        <div class="p-2">
            @if($blockResults->first()->block)
            <h3 class="text-base font-semibold text-gray-800 mb-3">{{ $blockResults->first()->block->name }}</h3>
            @else
            <h3 class="text-base font-semibold text-gray-800 mb-3">Unknown Block</h3>
            @endif

            <table class="w-full">
                <thead>
                    <tr class="text-left border-b-2 border-gray-200">
                        <th class="py-2 w-10 sm:w-16 text-xs">順位</th>
                        <th class="py-2 w-10 sm:w-20 text-xs">No.</th>
                        <th class="py-2 text-xs">氏名</th>
                        <th class="py-2 w-18 sm:w-20 text-xs">タイム</th>
                        <th class="py-2 w-16 sm:w-20 text-center text-xs"></th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @foreach($blockResults as $result)
                    <tr class="border-b border-gray-100">
                        <td class="py-2 font-medium">{{ $result->place }}</td>
                        <td class="py-2">{{ $result->bib }}</td>
                        <td class="py-2 break-all">{{ $result->name }}</td>
                        <td class="py-2 font-medium">{{ $result->time }}</td>
                        <td class="py-2 text-center">
                            @if($result->time !== 'DNS' && $result->time !== 'DNF')
                            <a href="{{ route('public.races.download-certificate', ['race' => $race, 'result' => $result]) }}" 
                               class="download-certificate-btn inline-block px-2 py-1 text-xs text-white bg-blue-600 hover:bg-blue-700 rounded"
                               data-result-id="{{ $result->id }}"
                               data-participant-name="{{ $result->name }}">
                                記録証
                            </a>
                            @else
                            <span class="text-xs text-gray-400">-</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endforeach

    {{-- ローディングスピナーを追加 --}}
    <x-loading-spinner id="certificate-loading" />
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const downloadButtons = document.querySelectorAll('.download-certificate-btn');
    const loadingSpinner = document.getElementById('certificate-loading');
    const raceName = @json($race->name);

    downloadButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            // 日付フォーマットの作成
            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const dateStr = `${year}${month}${day}`;

            // 選手名の取得
            const participantName = this.dataset.participantName;
            
            // ローディングスピナーを表示
            loadingSpinner.classList.remove('hidden');
            
            // 非同期でPDFを生成
            fetch(this.href)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.blob();
                })
                .then(blob => {
                    // ローディングスピナーを非表示
                    loadingSpinner.classList.add('hidden');
                    
                    // PDFをダウンロード
                    const url = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = `記録証_${raceName}_${participantName}_${dateStr}.pdf`;
                    document.body.appendChild(a);
                    a.click();
                    window.URL.revokeObjectURL(url);
                    document.body.removeChild(a);
                })
                .catch(error => {
                    console.error('ダウンロードエラー:', error);
                    loadingSpinner.classList.add('hidden');
                    alert('ダウンロード中にエラーが発生しました。もう一度お試しください。');
                });
        });
    });
});
</script>
@endpush
@endsection

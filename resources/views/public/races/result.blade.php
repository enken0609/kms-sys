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
                            <a href="{{ route('public.races.download', ['race' => $race->id, 'result' => $result->id]) }}" 
                               class="inline-block px-2 py-1 text-xs text-white bg-blue-600 hover:bg-blue-700 rounded">
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
</div>
@endsection

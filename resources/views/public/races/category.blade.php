@extends('layouts.public')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-8">
        <a href="{{ route('public.races.index') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            レース一覧に戻る
        </a>
    </div>

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">{{ $categories->first()->race->name }}</h1>
    </div>

    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        @foreach($categories as $category)
        <a href="{{ route('public.races.result', [$category->race->id, $category->id]) }}" 
           class="block group">
            <div class="card hover-scale p-6">
                <div class="flex flex-col space-y-4">
                    <h2 class="text-xl font-semibold text-gray-900 group-hover:text-blue-600 transition-colors">
                        {{ $category->name }}
                    </h2>
                    
                    <div class="flex items-center text-blue-600 group-hover:translate-x-2 transition-transform">
                        <span class="text-sm font-medium">結果を見る</span>
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </div>
            </div>
        </a>
        @endforeach
    </div>
</div>
@endsection

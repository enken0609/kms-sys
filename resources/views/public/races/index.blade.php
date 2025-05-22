@extends('layouts.public')

@section('content')
<div class="max-w-7xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">レース一覧</h1>
    
    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        @foreach($races as $race)
        <a href="{{ route('public.races.category', $race->id) }}" 
           class="block group">
            <div class="card hover-scale p-6">
                <div class="flex flex-col space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            {{ \Carbon\Carbon::parse($race->date)->format('Y年n月j日') }}
                        </span>
                    </div>
                    
                    <h2 class="text-xl font-semibold text-gray-900 group-hover:text-blue-600 transition-colors">
                        {{ $race->name }}
                    </h2>
                    
                    @if($race->description)
                    <p class="text-gray-600 text-sm line-clamp-2">
                        {{ $race->description }}
                    </p>
                    @endif
                    
                    <div class="flex items-center text-blue-600 group-hover:translate-x-2 transition-transform">
                        <span class="text-sm font-medium">詳細を見る</span>
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

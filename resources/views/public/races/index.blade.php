@extends('layouts.public')

@section('content')
<div class="container">
    <h2 class="mt-5 mb-4">レース一覧</h2>
    <div class="row">
        @foreach($races as $race)
        <div class="col-md-12 mb-4">
            <div class="rounded shadow">
                <a href="{{ route('public.races.show', $race->id) }}" class="text-decoration-none text-dark">
                    <div class="card-body d-flex flex-column flex-sm-row justify-content-start align-items-left">
                        <div class="date px-2 text-sm">
                            <p class="mb-0">{{ $race->date }}</p>
                        </div>
                        <div class="name px-2">
                            <h5 class="card-title mb-0 font-bold fs-5">{{ $race->name }}</h5>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

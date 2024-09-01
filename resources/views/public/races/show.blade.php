@extends('layouts.public')

@section('content')
<div class="container mt-5">
  <h2 class="mb-4">{{ $race->name }}</h2>
  <div class="row">
    @foreach($categories as $category)
    <div class="col-md-12 mb-4">
      <div class="rounded shadow">
        <div class="card-body d-flex flex-md-row justify-content-between align-items-center">
          <div class="name px-2">
            <h5 class="card-title mb-0 fs-6">{{ $category->name }}</h5>
          </div>
          <div class=" buttons px-2">
            <a href="{{ route('public.result', [$race->id, $category->id]) }}"
              class="btn btn-danger btn-sm mx-2">リザルト・記録証</a>
            <a href="{{ route('public.leaderboard', [$race->id, $category->id]) }}"
              class="btn btn-info btn-sm mx-2">速報</a>
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>
</div>
@endsection

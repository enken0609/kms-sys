@extends('layouts.public')

@section('content')
<div class="container">
  <h2 class="mt-5 mb-4">カテゴリー一覧</h2>
  <div class="row">
    @foreach($categories as $category)
    <div class="col-md-12 mb-4">
      <div class="rounded shadow">
        <a href="{{ route('public.races.result',[$category->race->id, $category->id]) }}"
          class="text-decoration-none text-dark">
          <div class="card-body d-flex flex-column flex-sm-row justify-content-start align-items-left">
            <div class="name px-2">
              <h5 class="card-title mb-0 font-bold fs-5">{{ $category->name }}</h5>
            </div>
          </div>
        </a>
      </div>
    </div>
    @endforeach
  </div>
</div>
@endsection

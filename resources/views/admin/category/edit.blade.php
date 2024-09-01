@extends('layouts.app')

@section('content')
<div class="container mt-5">
  <h2 class="mb-4">{{ $race->name }}</h2>
  <form action="{{ route('admin.category.update', [$race->id, $category->id]) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
      <label for="name">カテゴリー名</label>
      <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
    </div>
    <div class="form-group">
      <label for="status">Status ※1:開催中、2:終了</label>
      <input type="text" name="status" class="form-control" value="{{ $category->status }}" required>
    </div>
    <div class="form-group">
      <label for="webscorer_race_id">Webscorer Race ID</label>
      <input type="number" name="webscorer_race_id" class="form-control" value="{{ $category->webscorer_race_id }}"
        required>
    </div>
    <button type="submit" class="btn btn-primary">編集</button>
  </form>
</div>
@endsection

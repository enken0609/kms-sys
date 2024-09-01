@extends('layouts.app')

@section('content')
<div class="container mt-5">
  <h2 class="mb-4">新規登録</h2>
  <form action="{{ route('admin.category.store', $race->id) }}" method="POST">
    @csrf
    <div class="form-group">
      <label for="name">カテゴリー名</label>
      <input type="text" name="name" class="form-control" required>
    </div>
    <div class="form-group">
      <label for="status">Status ※1:開催中、2:終了</label>
      <input type="text" name="status" class="form-control" required>
    </div>
    <div class="form-group">
      <label for="webscorer_race_id">Webscorer Race ID</label>
      <input type="number" name="webscorer_race_id" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">登録</button>
  </form>
</div>
@endsection

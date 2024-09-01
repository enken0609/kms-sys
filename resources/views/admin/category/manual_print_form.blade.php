@extends('layouts.app')

@section('content')
<div class="container mt-5">
  <h2 class="mb-4">賞状手動印刷フォーム</h2>
  <form action="{{ route('admin.manual.print') }}" method="POST">
    @csrf
    <div class="form-group">
      <label for="category">カテゴリー名</label>
      <input type="text" name="category" class="form-control" required>
    </div>
    <div class="form-group">
      <label for="rank">順位</label>
      <input type="text" name="rank" class="form-control" required>
    </div>
    <div class="form-group">
      <label for="name">氏名</label>
      <input type="text" name="name" class="form-control" required>
    </div>
    <div class="form-group">
      <label for="time">タイム</label>
      <input type="text" name="time" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">印刷</button>
  </form>
</div>
@endsection
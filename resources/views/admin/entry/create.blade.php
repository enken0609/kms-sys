@extends('layouts.app')

@section('content')
<div class="container mt-5">
  <h2 class="mb-4">参加者新規登録</h2>
  <form action="{{ route('admin.entry.store', $race->id) }}" method="POST">
    @csrf
    <div class="form-group">
      <label for="name">氏名</label>
      <input type="text" name="name" class="form-control" required>
    </div>
    <div class="form-group">
      <label for="name_kana">氏名カナ</label>
      <input type="text" name="name_kana" class="form-control" required>
    </div>
    <div class="form-group">
      <label for="gender">性別</label>
      <input type="text" name="gender" class="form-control" required>
    </div>
    <div class="form-group">
      <label for="age">年齢</label>
      <input type="number" name="age" class="form-control">
    </div>
    <div class="form-group">
      <label for="team_name">所属</label>
      <input type="text" name="team_name" class="form-control">
    </div>
    <div class="form-group">
      <label for="start_time">スタート時間</label>
      <input type="time" name="start_time" class="form-control" step="1" required>
    </div>
    <div class="form-group">
      <label for="bib_number">ゼッケン番号</label>
      <input type="text" name="bib_number" class="form-control" required>
    </div>
    <div class="form-group">
      <label for="category">カテゴリー</label>
      <input type="text" name="category" class="form-control" required>
    </div>
    <div class="form-group">
      <label for="award_category">表彰区分</label>
      <input type="text" name="award_category" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">登録</button>
  </form>
</div>
@endsection

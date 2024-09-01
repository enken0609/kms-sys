@extends('layouts.app')

@section('content')
<div class="container mt-5">
  <h2 class="mb-4">編集</h2>
  <form action="{{ route('admin.entry.update', [$race->id, $entry->id]) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
      <label for="name">氏名</label>
      <input type="text" name="name" class="form-control" value="{{ $entry->name }}" required>
    </div>
    <div class="form-group">
      <label for="name_kana">氏名カナ</label>
      <input type="text" name="name_kana" class="form-control" value="{{ $entry->name_kana }}" required>
    </div>
    <div class="form-group">
      <label for="gender">性別</label>
      <input type="text" name="gender" class="form-control" value="{{ $entry->gender }}" required>
    </div>
    <div class="form-group">
      <label for="age">年齢</label>
      <input type="number" name="age" class="form-control" value="{{ $entry->age }}" required>
    </div>
    <div class="form-group">
      <label for="team_name">所属</label>
      <input type="text" name="team_name" class="form-control" value="{{ $entry->team_name }}">
    </div>
    <div class="form-group">
      <label for="start_time">スタート時間</label>
      <input type="time" name="start_time" class="form-control" step="1" value="{{ $entry->start_time }}" required>
    </div>
    <div class="form-group">
      <label for="bib_number">ゼッケン</label>
      <input type="text" name="bib_number" class="form-control" value="{{ $entry->bib_number }}" required>
    </div>
    <div class="form-group">
      <label for="category">Categoryカテゴリー</label>
      <input type="text" name="category" class="form-control" value="{{ $entry->category }}" required>
    </div>
    <div class="form-group">
      <label for="award_category">表彰区分</label>
      <input type="text" name="award_category" class="form-control" value="{{ $entry->award_category }}" required>
    </div>
    <button type="submit" class="btn btn-primary">編集</button>
  </form>
</div>
@endsection

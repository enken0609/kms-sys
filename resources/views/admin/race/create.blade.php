@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h2>新規登録</h2>
      <div class="card shadow h-100 p-4">
        <form action="{{ route('admin.race.store') }}" method="POST">
          @csrf
          <div class="form-group">
            <label for="name">大会名</label>
            <input type="text" name="name" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="description">備考</label>
            <textarea name="description" class="form-control" required></textarea>
          </div>
          <div class="form-group">
            <label for="date">日付</label>
            <input type="date" name="date" class="form-control" required>
          </div>
          <button type="submit" class="btn btn-primary">登録</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

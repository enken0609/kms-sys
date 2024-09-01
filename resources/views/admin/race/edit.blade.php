@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-8 offset-md-2">
      <h2>編集</h2>
      <div class="card shadow h-100 p-4">
        <form action="{{ route('admin.race.update', $race->id) }}" method="POST">
          @csrf
          @method('PUT')
          <div class="form-group">
            <label for="name">大会名</label>
            <input type="text" name="name" class="form-control" value="{{ $race->name }}" required>
          </div>
          <div class="form-group">
            <label for="description">備考</label>
            <textarea name="description" class="form-control" required>{{ $race->description }}</textarea>
          </div>
          <div class="form-group">
            <label for="date">日付</label>
            <input type="date" name="date" class="form-control" value="{{ $race->date }}" required>
          </div>
          <button type="submit" class="btn btn-primary">編集</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

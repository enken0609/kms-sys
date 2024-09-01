@extends('layouts.app')

@section('content')
<div class="container mt-5">
  <h2 class="mb-4">{{ $race->name }}</h2>
  @if(session('success'))
  <div class="alert alert-success">
    {{ session('success') }}
  </div>
  @endif
  @if(session('error'))
  <div class="alert alert-danger">
    {{ session('error') }}
  </div>
  @endif
  <form action="{{ route('admin.entry.import', $race->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
      <label for="file">Excel File</label>
      <input type="file" name="file" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">インポート</button>
  </form>
</div>
@endsection

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
  <div class="p-2 text-right">
    <a href="{{ route('admin.entry.index', $race->id) }}" class="btn btn-dark">エントリー一覧</a>
    <a href="{{ route('admin.category.create', $race->id) }}" class="btn btn-primary">新規登録</a>
  </div>
  <div class="row">
    <table class="table">
      <thead>
        <tr>
          <th>カテゴリー名</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
        @foreach($categories as $category)
        <tr>
          <td><a href="{{ route('admin.category.result', [$race->id, $category->id]) }}">{{ $category->name }}</a></td>
          <td>
            <a href="{{ route('admin.category.edit', [$race->id, $category->id]) }}" class="btn btn-warning mr-3">編集</a>
            <form action="{{ route('admin.category.destroy', [$race->id, $category->id]) }}" method="POST"
              class="d-inline-block mr-3">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger">削除</button>
            </form>
            <form action="{{ route('admin.category.update_results', [$race->id, $category->id]) }}" method="POST"
              class="d-inline-block">
              @csrf
              <button type="submit" class="btn btn-info">API更新</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>

  </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container race">
  <div class="row">
    <div class="col-md-12">
      <h2>レース一覧</h2>
      <div class="p-2 text-right">
        <a href="{{ route('admin.race.create') }}" class="btn btn-primary">新規登録</a>
      </div>
      <div class="card shadow h-100 p-4">
        <table class="table">
          <thead>
            <tr>
              <th>大会名</th>
              <th>備考</th>
              <th>日付</th>
              <th>操作</th>
            </tr>
          </thead>
          <tbody>
            @foreach($races as $race)
            <tr>
              <td><a href="{{ route('admin.category.index', $race->id) }}">{{ $race->name }}</a></td>
              <td>{{ $race->description }}</td>
              <td>{{ $race->date }}</td>
              <td>
                <a href="{{ route('admin.race.edit', $race->id) }}" class="btn btn-warning">編集</a>
                <form action="{{ route('admin.race.destroy', $race->id) }}" method="POST" style="display:inline-block;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger">削除</button>
                </form>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

@endsection

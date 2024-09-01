@extends('layouts.app')

@section('content')
<div class="container mt-5">
  <h2 class="mb-4">参加者リスト</h2>
  <div class="p-2 text-right mb-2">
    <a href="{{ route('admin.entry.create', $race->id) }}" class="btn btn-primary">新規登録</a>
    <a href="{{ route('admin.entry.import.form', $race->id) }}" class="btn btn-success ml-2">エクセルインポート</a>
  </div>
  <div class="row">
    <div class="table-responsive">
      <table class="table bg-none">
        <thead class="thead">
          <tr>
            <th scope="col">ゼッケン</th>
            <th scope="col">氏名</th>
            <th scope="col">年齢</th>
            <th scope="col" style="max-width: 200px;">カテゴリー</th>
            <th scope="col">所属</th>
            <th scope="col">操作</th>
          </tr>
        </thead>
        <tbody>
          @foreach($entries as $entry)
          <tr>
            <td>{{ $entry->bib_number }}</td>
            <td>{{ $entry->name }}</td>
            <td>{{ $entry->age }}</td> <!-- Assuming 'year' is 'age' in your data -->
            <td style="max-width: 200px;">{{ $entry->category }}</td>
            <td>{{ $entry->team_name }}</td>
            <td>
              <a href="{{ route('admin.entry.edit', [$race->id, $entry->id]) }}" class="btn btn-primary">編集</a>
              <form action="{{ route('admin.entry.destroy', [$race->id, $entry->id]) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger ml-2" onclick="return confirm('本当に削除しますか？')">削除</button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection

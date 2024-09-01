@extends('layouts.public')

@section('content')
<div class="container mt-5 leaderboard">
  <h2 class="mb-4">【速報】{{ $category->name }}</h2>
  <div class="mb-2 text-right">
    <a href="{{ route('public.races.show', ['race' => $category->race_id]) }}"
      class="btn btn-sm btn-secondary back-btn">一覧に戻る</a>
  </div>
  <div class="row mb-4">
    <div class="col-md-12 mb-1">
      <div class="table-responsive p-2">
        <table class="table">
          <thead>
            <tr>
              <th scope="col" class="text-center">順位</th>
              <th scope="col" class="text-center">ゼッケン</th>
              <th scope="col">氏名</th>
              <th scope="col">年齢</th>
              <th scope="col">タイム</th>
            </tr>
          </thead>
          <tbody>
            @foreach($results as $result)
            <tr>
              <td class="text-center">{{ $result->place }}</td>
              <td class="text-center">{{ $result->bib }}</td>
              <td>{{ $result->name }}</td>
              <td>{{ $result->age }}</td>
              <td>{{ $result->time }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection

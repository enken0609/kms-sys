@extends('layouts.public')

@section('content')
<div class="container mt-5 leaderboard">
  <h2 class="mb-4">リザルト $category->name </h2>
  <div class="mb-2 text-right">
    <a href="#" class="btn btn-sm btn-secondary back-btn">一覧に戻る</a>
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
              <th scope="col">タイム</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="text-center">1</td>
              <td class="text-center">1</td>
              <td>name</td>
              <td>年齢</td>
              <td>タイム</td>
              <td><a href="#" class="btn btn-danger btn-sm mx-2">記録証</a></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection

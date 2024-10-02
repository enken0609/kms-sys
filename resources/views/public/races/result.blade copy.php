@extends('layouts.public')

@section('content')
<div class="result-list container mt-5">
  <h2 class="mb-4 text-2xl">{{ $category->name }}</h2>
  <div class="row d-block">
    <div class="card shadow h-100 p-4 mb-4">
      <h3 class="mb-4 text-xl">総合女子</h3>
      <table class="table">
        <thead>
          <tr>
            <th style="min-width: 35px;">順位</th>
            <th style="min-width: 50px;">ゼッケン</th>
            <th style="min-width: 80px;">氏名</th>
            <th style="min-width: 40px;">タイム</th>
            <th style="min-width: 70px;"></th>
          </tr>
        </thead>
        <tbody>
          @foreach($femaleResults as $femaleResult)
          <tr>
            <td>{{ $femaleResult->place }}</td>
            <td>{{ $femaleResult->bib }}</td>
            <td>{{ $femaleResult->name }}</td>
            <td>{{ $femaleResult->time }}</td>
            <td><a href="{{ route('public.races.download', ['race' => $race->id, 'result' => $femaleResult->id]) }}"
                class="btn btn-danger btn-sm">記録証</a></td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>


    <div class="card shadow h-100 p-4">
      <h3 class="mb-4 text-xl">総合男子</h3>
      <table class="table">
        <thead>
          <tr>
            <th style="min-width: 35px;">順位</th>
            <th style="min-width: 50px;">ゼッケン</th>
            <th style="min-width: 80px;">氏名</th>
            <th style="min-width: 40px;">タイム</th>
            <th style="min-width: 70px;"></th>
          </tr>
        </thead>
        <tbody>
          @foreach($maleResults as $maleResult)
          <tr>
            <td>{{ $maleResult->place }}</td>
            <td>{{ $maleResult->bib }}</td>
            <td>{{ $maleResult->name }}</td>
            <td>{{ $maleResult->time }}</td>
            <td><a href="{{ route('public.races.download', ['race' => $race->id, 'result' => $maleResult->id]) }}"
                class="btn btn-danger btn-sm">記録証</a></td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection

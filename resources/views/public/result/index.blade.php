@extends('layouts.public')

@section('content')
<div class="container mt-5 result">
  <h2 class="mb-4">【リザルト】{{ $category->name }}</h2>
  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th scope="col" class="text-center">順位</th>
          <th scope="col" class="text-center">ゼッケン</th>
          <th scope="col">氏名</th>
          <th scope="col">タイム</th>
          <th scope="col" class="text-center"></th>
        </tr>
      </thead>
      <tbody>
        @foreach($results as $result)
        <tr>
          <td class="text-center">{{ $result->place }}</td>
          <td class="text-center">{{ $result->bib }}</td>
          <td class="text-left">{{ $result->name }}</td>
          <td class="text-left">{{ $result->time }}</td>
          <td class="text-center">
            <a href="{{ route('public.result.download', [$category->id, $result->id]) }}"
              class="btn btn-danger btn-sm btn-certificate">完走証</a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection

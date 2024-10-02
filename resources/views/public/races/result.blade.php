@extends('layouts.public')

@section('content')
<div class="result-list container mt-5">

  <h2 class="mb-4 text-2xl">{{ $category->name }}</h2>
  <div class="row d-block">

    @foreach($results as $block_id => $blockResults)
    <div class="card shadow h-100 p-4 mb-4">
      @if($blockResults->first()->block)
      <h3 class="mb-4 text-xl">{{ $blockResults->first()->block->name }}</h3>
      @else
      <h3 class="mb-4 text-xl">Unknown Block</h3>
      @endif
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
          @foreach($blockResults as $result)
          <tr>
            <td>{{ $result->place }}</td>
            <td>{{ $result->bib }}</td>
            <td>{{ $result->name }}</td>
            <td>{{ $result->time }}</td>
            <td>
              <a href="{{ route('public.races.download', ['race' => $race->id, 'result' => $result->id]) }}" class="btn btn-danger btn-sm @if ( $result->time === 'DNS' || $result->time === 'DNF' ) disabled
                @endif">
                記録証
              </a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    @endforeach



  </div>
</div>
@endsection

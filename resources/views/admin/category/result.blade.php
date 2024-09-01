@extends('layouts.app')

@section('content')
<div class="container mt-5 result">
  <h2 class="mb-4">【リザルト】{{ $category->name }}</h2>

  <!-- 賞状手動印刷ボタン -->
  <div class="mb-4 text-right">
    <a href="{{ route('admin.manual.print') }}" class="btn btn-dark">賞状手動印刷</a>
  </div>

  <!-- 印刷用フォーム -->
  <div class="mb-4">
    <form action="{{ route('admin.category.result', [$race->id, $category->id]) }}" method="GET" class="form-inline">
      <div class="form-group mb-2">
        <label for="bib" class="sr-only">ゼッケン番号</label>
        <input type="text" class="form-control" id="bib" name="bib" placeholder="ゼッケン番号を入力">
      </div>
      <button type="submit" class="btn btn-primary mb-2 ml-2">検索</button>
    </form>
  </div>

  <!-- 検索結果表示 -->
  @if(isset($bibResult))
  <div class="mb-4">
    <h4>検索結果</h4>
    <div class="card">
      <div class="card-body">
        <p><strong>ゼッケン:</strong> {{ $bibResult['bib'] }}</p>
        <p><strong>氏名:</strong> {{ $bibResult['name'] }}</p>
        <p><strong>タイム:</strong> {{ $bibResult['time'] }}</p>
        <p><strong>順位:</strong> {{ $bibResult['place'] }}</p>
        <form
          action="{{ route('admin.category.downloadCertificate', [$race->id, $category->id, $bibResult['id'], $bibResult['award_place'], $bibResult['award_place_count'], $bibResult['overall_count']]) }}"
          method="POST">
          @csrf
          <button type="submit" class="btn btn-success">印刷</button>
        </form>
      </div>
    </div>
  </div>
  @endif

  <div class="table-responsive">
    @foreach($groupedResults as $awardCategory => $gResults)
    <h3 class="mb-2">{{ $awardCategory }}</h3>
    <table class="table mb-4">
      <thead>
        <tr>
          <th scope="col" class="text-center">順位</th>
          <th scope="col" class="text-center">ゼッケン</th>
          <th scope="col">氏名</th>
          <th scope="col">氏名カナ</th>
          <th scope="col">年齢</th>
          <th scope="col">タイム</th>
          <th scope="col" class="text-center"></th>
          <th scope="col" class="text-center"></th>
        </tr>
      </thead>
      <tbody>
        @foreach($gResults as $result)
        <tr>
          <td class="text-center">
            {{ $result['award_place'] }}
          </td>
          <td class="text-center">{{ $result['bib'] }}</td>
          <td class="text-left">{{ $result['name'] }}</td>
          <td class="text-left">{{ $result['kana'] }}</td>
          <td class="text-left">{{ $result['age'] }}</td>
          <td class="text-left">{{ $result['time'] }}</td>
          <td class="text-center">
            <form
              action="{{ route('admin.category.downloadCertificate', [$race->id, $category->id, $result['id'], $result['award_place'], $result['award_place_count'], $result['overall_count']]) }}"
              method="POST">
              @csrf
              <button type="submit" class="btn btn-danger btn-sm"
                {{ in_array($result['time'], ['DNS', 'DNF']) ? 'disabled' : '' }}>
                完走証
              </button>
            </form>
          </td>
          <td class="text-center">
            <form action="{{ route('admin.auto.print', $result) }}" method="POST">
              @csrf
              <button type="submit" class="btn btn-success btn-sm"
                {{ in_array($result['time'], ['DNS', 'DNF']) ? 'disabled' : '' }}>賞状印刷</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    @endforeach
  </div>
</div>
@endsection

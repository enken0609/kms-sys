<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Certificate</title>
  <style>
  @page {
    size: A4;
    margin: 0;
  }

  @font-face {
    font-family: Noto Sans JP;
    font-style: normal;
    font-weight: normal;
    src: url('{{ storage_path("fonts/NotoSansJP-Regular.ttf") }}');
  }

  @font-face {
    font-family: Noto Sans JP;
    font-style: normal;
    font-weight: bold;
    src: url('{{ storage_path("fonts/NotoSansJP-Bold.ttf") }}');
  }

  html,
  body {
    font-family: ipag, sans-serif;
    width: 100%;
    height: 100%;
    margin: 0;
    padding: 0;
  }

  img {
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
    z-index: -1;
  }

  .details {
    position: absolute;
    top: 270;
    right: 0;
    bottom: 0;
    left: 0;
    margin: auto;
  }

  .details p {
    font-size: 20px;
    text-align: center;
    font-family: 'Noto Sans JP', sans-serif;
    margin-top: -7px;
    margin-bottom: 0;
    font-weight: bold;
  }

  .details .category,
  .details .time {
    font-size: 30px;
  }

  .details .rank {
    font-size: 50px;
  }

  .details .name {
    font-size: 50px;
  }
  </style>
</head>

<body>
  <!-- <img src="{{ Vite::asset('resources/img/ozeiwakuraskyvalley_award_template.png') }}" alt="Award Template"> -->
  <div class="details">
    <p class="category">{{ $category }}</p>
    <p class="rank">第{{ $rank }}位</p>
    <p class="name">{{ $name }} 殿</p>
    <p class="time">{{ $time }}</p>
  </div>
</body>

</html>

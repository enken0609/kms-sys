<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Certificate</title>
  <style>
  @page {
    size: B5;
    margin: 0;
  }

  /* @font-face {
    font-family: ipag;
    font-style: normal;
    font-weight: normal;
    src: url('{{ storage_path("fonts/ipag.ttf") }}');
  }

  @font-face {
    font-family: ipag;
    font-style: bold;
    font-weight: bold;
    src: url('{{ storage_path("fonts/ipag_bold_791fcc91e38f54557d41f36aba597ce8.ttf") }}');
  } */

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
    bottom: 165px;
    left: 70px;
  }

  .details p {
    font-size: 20px;
    text-align: left;
    font-family: 'Noto Sans JP', sans-serif;
    margin-top: -7px;
    margin-bottom: 0;
    font-weight: bold;
  }

  .item_box p {
    text-align: left;
    margin: 0 auto;
    width: 350px;
  }
  </style>
</head>

<body>
  <img src="data:image/png;base64,{{ $image_data }}">
  <div class="details">
    <div class="item_box">
      <p>部&nbsp;&nbsp;&nbsp;&nbsp;門&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $data['category'] }}</p>
    </div>
    <div class="item_box">
      <p>氏&nbsp;&nbsp;&nbsp;&nbsp;名&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $data['name'] }}</p>
    </div>
    <div class="item_box">
      <p>記&nbsp;&nbsp;&nbsp;&nbsp;録&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $data['time'] }}</p>
    </div>
    <div class="item_box">
      <p>順&nbsp;&nbsp;&nbsp;&nbsp;位&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $data['place'] }}位</p>
    </div>
  </div>
</body>

</html>

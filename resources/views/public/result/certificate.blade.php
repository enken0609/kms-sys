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
    bottom: 150px;
    left: 160px;
  }

  .details p {
    font-size: 20px;
    text-align: left;
    font-family: 'Noto Sans JP', sans-serif;
    margin-top: -7px;
    margin-bottom: 0;
    font-weight: bold;
  }
  </style>
</head>

<body>
  <!-- <img src="{{ asset('resources/img/ozeiwakuraskyvalley_certificate_template.png') }}" alt="Certificate Template"> -->
  <div class="details">
    <p>{{ $bib }}</p>
    <p>{{ $category }}</p>
    <p>{{ $name }}</p>
    <p>{{ $time }}</p>
    <p>{{ $rank }}</p>
    <p>{{ $rank }}</p>
  </div>
</body>

</html>

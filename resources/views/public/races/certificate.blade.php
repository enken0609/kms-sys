<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>記録証</title>
  <style>
  @page {
    size: {{ strtolower($template->paper_size) }} {{ $template->orientation }};
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
    font-family: 'Noto Sans JP';
    font-style: normal;
    font-weight: normal;
    src: url('{{ storage_path("fonts/NotoSansJP-Regular.ttf") }}');
  }

  @font-face {
    font-family: 'Noto Sans JP';
    font-style: normal;
    font-weight: bold;
    src: url('{{ storage_path("fonts/NotoSansJP-Bold.ttf") }}');
  }

  body {
    font-family: 'Noto Sans JP', sans-serif;
    margin: 0;
    padding: 0;
    width: 100%;
    height: 100%;
    position: relative;
  }

  .template-container {
    position: relative;
    width: 100%;
    height: 100vh;
  }

  .template-image {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: -1;
  }

  .certificate-element {
    position: absolute;
    font-family: 'Noto Sans JP', sans-serif;
    font-weight: bold;
    white-space: nowrap;
  }
  </style>
</head>

<body>
  <div class="template-container">
    <img src="data:image/jpeg;base64,{{ $image_data }}" class="template-image">

    @foreach($layout_config['elements'] as $key => $element)
      <div class="certificate-element" style="
        left: {{ $element['x'] }}px;
        top: {{ $element['y'] }}px;
        font-size: {{ $element['font_size'] }}px;
        color: {{ $element['color'] }};
      ">
        {{ $data[$key] ?? '' }}
      </div>
    @endforeach
  </div>
</body>

</html>

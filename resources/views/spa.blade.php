@php
$config = [
    'appName' => config('app.name'),
    'locale' => $locale = app()->getLocale(),
    'locales' => config('app.locales'),
    'githubAuth' => config('services.github.client_id'),
    'ContractType' => App\Enums\ContractType::getAllValues(),
    'IntroducerType' => App\Enums\IntroducerType::getAllValues(),
    'ISDType' => App\Enums\ISDType::getAllValues(),
    'NthType' => App\Enums\NthType::getAllValues(),
    'SexType' => App\Enums\SexType::getAllValues(),
];
$appJs = mix('dist/js/app.js');
$appCss = mix('dist/css/app.css');
@endphp
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>{{ config('app.name') }}</title>
  <link rel="stylesheet" href="{{ mix('dist/css/app.css') }}">
</head>
<body>
  <div id="app"></div>

  <script>
    window.config = @json($config);
  </script>

  <script src="{{ mix('dist/js/app.js') }}"></script>
</body>
</html>

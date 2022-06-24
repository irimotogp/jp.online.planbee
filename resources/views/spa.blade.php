@php
$config = [
    'appName' => config('app.name'),
    'locale' => $locale = app()->getLocale(),
    'locales' => config('app.locales'),
    'githubAuth' => config('services.github.client_id'),
    'ContractType' => App\Enums\ContractType::getAllValues(),
    'IntroducerType' => App\Enums\IntroducerType::getFrontAllValues(),
    'ISDType' => App\Enums\ISDType::getAllValues(),
    'NthType' => App\Enums\NthType::getAllValues(),
    'SexType' => App\Enums\SexType::getAllValues(),
    'ShippingAddressType' =>  App\Enums\ShippingAddressType::getAllValues(),
    'WEGType' =>  App\Enums\WEGType::getAllValues(),
    'InitialPaymentType' =>  App\Enums\InitialPaymentType::getAllValues(),
    'PaymentNumberType' =>  App\Enums\PaymentNumberType::getAllValues(),
    'CardCompanyType' =>  App\Enums\CardCompanyType::getAllValues(),
    'MonthlyPaymentType' =>  App\Enums\MonthlyPaymentType::getAllValues(),
    'DesireContacType' =>  App\Enums\DesireContacType::getAllValues(),
    'DesireDateTimeType' =>  App\Enums\DesireDateTimeType::getAllValues(),
    'BasicFeeType' => App\Enums\BasicFeeType::getAllValues(),
    'CommercialPrivacyType' => App\Enums\CommercialPrivacyType::getAllValues(),
    'DirectionType' => App\Enums\DirectionType::getFormAllValues()

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
  <link rel="stylesheet" href="{{ (str_starts_with($appCss, '//') ? 'http:' : '').$appCss }}">
</head>
<body>
  <div id="app"></div>

  <script>
    window.config = @json($config);
  </script>

  <script src="{{ (str_starts_with($appJs, '//') ? 'http:' : '').$appJs }}"></script>
</body>
</html>

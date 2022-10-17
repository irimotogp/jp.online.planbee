@component('mail::message')
{{ $data->sinsei_name }}様<br><br>
プランビー取次店の{{ $data->syoukai_name }}様より登録申請フォームのURLが送信されました。 <br>このURLの有効期限は24時間です。<br>24時間を経過すると使用できなくなりますのでお早めに入力、送信してください。<br><br>
{{ $data->getAccessUrl() }}
<br><br>株式会社プランビー
@endcomponent



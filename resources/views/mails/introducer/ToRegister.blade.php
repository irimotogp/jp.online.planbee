@component('mail::message')
{{ $data->sinsei_name }}様
取次店の{{ $data->sinsei_name }}様よりプランビー取次店登録申請フォームのURLが送信されました。
このURLの有効期限は24時間です。24時間を経過すると使用できなくなりますのでお早めに入力、送
信してください。
{{ $data->getAccessUrl() }}
@endcomponent



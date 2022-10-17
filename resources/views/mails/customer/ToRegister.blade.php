@component('mail::message')
{{ $data->kanji }}様

この度は、プランビーのレンタルお申し込みをいただき誠にありがとうございます。<br>
※  重要事項の記載がございますので、このメールは必ず保存してください。<br>

＜今後の流れについて＞<br>
1.　契約内容確認のお電話<br>
ご指定の時間帯に弊社からお電話いたします。<br>

2.　初期費用のお支払い<br>
■クレジットカード決済の場合：お電話終了後に決済いたします。<br>
決済日の指定がありましたらお電話の際にお申し付けください。<br>

■銀行振込の場合：下記振込先までお振り込みください。<br>
【振込先】http://bit.ly/1M7qSZK<br>

3．月額料の口座振替払いを選択された方のみご確認ください。<br>
「口座振替依頼書」を郵送いたしますので、記入・捺印後にご返信ください。<br>
（印刷が可能でしたら、下記PDFもご利用いただけます。）<br>

以上が完了しましたら、ご登録・商品発送となります。<br>
本メールの内容や契約内容についてご不明な点は、お気軽にお問い合わせください。<br>

<b>■口座振替依頼書（PDF）ダウンロードについて</b><br>
STEP１　口座振替依頼書をダウンロードして印刷してください。<br>
STEP２　記入・捺印後、郵送にてご提出ください。<br>
・口座振替依頼書<br>
https://planbee.co.jp/pdf/kouzahurikae.pdf<br>
・口座振替依頼書 記入例<br>
https://planbee.co.jp/pdf/kouzahurikae_case.pdf<br>
・A4印刷用 返信用封筒<br>
https://bit.ly/3Mj2Mxb<br>

【電話】050-1745-9000（平日10～17時）<br>
【メール】info@planbee.co.jp<br>
【LINE】個別のお問い合わせにも対応しています。<br>
ともだち追加はこちらから  https://lin.ee/PpW6y3G<br>
【会社情報】<br>

株式会社プランビー<br>
代表取締役　井利元　聖史<br>
〒940-2039　新潟県長岡市関原南2-4077-1<br>

以下、ご入力いただいた申請内容です。<br>
=====================================================
性別：　{{ \App\Enums\SexType::getAllValues()[$data->sex_type] }}<br>
@if($data->sex_type == \App\Enums\SexType::CORPORATION)
法人名：　{{ $data->corp_kanji }} {{ $data->corp_kata }}<br>
代表者名：　{{ $data->rep_kanji_sei }} {{ $data->rep_kanji_mei }}<br>
　　　　　　{{ $data->rep_kata_sei }} {{ $data->rep_kata_mei }}<br>
@else
氏名：　{{ $data->kanji_sei }} {{ $data->kanji_mei }}<br>
　　　　{{ $data->kata_sei }} {{ $data->kata_mei }}<br>
@endif
生年月日：　{{ $data->birthday }}<br>
郵便番号：　{{ $data->zip1 }}<br>
都道府県：　{{ $data->pref1 }}<br>
住所１（番地まで）：　{{ $data->city1 }}<br>
住所２（マンション名・号室）：　{{ $data->addr1 }}<br>
自宅電話番号：　{{ $data->home_phone }}<br>
FAX番号：　{{ $data->fax }}<br>
携帯電話：　{{ $data->mobile_phone }}<br>
携帯電話（予備）：　{{ $data->mobile_phone2 }}<br>
メールアドレス：　{{ $data->sinsei_email }}<br>
メールアドレス（予備）：　{{ $data->phone_email }}<br>
@if($data->sex_type != \App\Enums\SexType::CORPORATION)
勤務先名：　{{ $data->work_place_name }}<br>
勤務先電話番号：　{{ $data->work_place_phone }}<br>
@endif
契約タイプ：　{{ \App\Enums\ContractType::getAllValues()[$data->contract_type] }}<br>
@if($data->contract_type == \App\Enums\ContractType::BULK)
配送先指定：　{{ \App\Enums\ShippingAddressType::getAllValues()[$data->shipping_address_type] }}<br>
@if($data->shipping_address_type != \App\Enums\ShippingAddressType::CURRENT)
配送先-郵便番号：　{{ $data->zip2 }}<br>
配送先-都道府県：　{{ $data->pref2 }}<br>
配送先-住所１（番地まで）：　{{ $data->city2 }}<br>
配送先-住所２（マンション名・号室）：　{{ $data->addr2 }}<br>
宛名：　{{ $data->receiver_name }}<br>
宛先電話番号：　{{ $data->receiver_phone }}<br>
@endif
@endif
初期費用支払方法：　{{ \App\Enums\InitialPaymentType::getAllValues()[$data->initial_payment_type] }}<br>
@if($data->initial_payment_type == \App\Enums\ContractType::BULK)
支払い回数：　{{ \App\Enums\PaymentNumberType::getAllValues()[$data->payment_number_type] }}<br>
カード会社：　{{ \App\Enums\CardCompanyType::getAllValues()[$data->card_company_type] }}<br>
カード番号：　{{ $data->card_number }}<br>
カード名義：　{{ $data->card_name }}<br>
有効期限：　{{ $data->expiration_date }}<br>
@endif
@if($data->contract_type != \App\Enums\ContractType::BULK)
月額料支払方法：　{{ \App\Enums\MonthlyPaymentType::getAllValues()[$data->monthly_payment_type] }}<br>
@endif
契約商品：　{{ $data->product->display_name }}<br>
@if($data->product_id && $data->product->cashback == 1)
銀行名：　{{ $data->bank_name }}<br>
銀行コード：　{{ $data->bank_code }}<br>
支店名：　{{ $data->branch_name }}<br>
支店コード：　{{ $data->branch_code }}<br>
預金種目：　{{ $data->deposit->name }}<br>
口座番号：　{{ $data->account_number }}<br>
口座名義（ｶﾅ）：　{{ $data->account_name }}<br>
@endif
@if($data->identity_doc)
本人確認書類：　{{ $data->identity_doc_url }}<br>
@endif
@if($data->identity_doc2)
本人確認書類（予備）：　{{ $data->identity_doc2_url }}<br>
@endif
希望登録月：　{{ $data->desire_month }}月<br>
本人確認の希望連絡先：　{{ \App\Enums\DesireContacType::getAllValues()[$data->desire_contact_type] }}<br>
希望日時：　{{ \App\Enums\DesireDateTimeType::getAllValues()[$data->desire_datetime_type] }}<br>
@if($data->desire_datetime_type == \App\Enums\DesireDateTimeType::SPECIAL)
{{ $data->desire_auth_month }}月{{ $data->desire_auth_day }}日 {{ $data->desire_start_h }}時{{ $data->desire_start_m }}分～{{ $data->desire_end_h }}時{{ $data->desire_end_m }}分<br>
@endif
@if($data->product_options)
商品オプション：<br>
@foreach($data->product_options as $product_option)
・{{ $product_option->name_price }}<br>
@endforeach
@endif
基本取付工賃：　{{ \App\Enums\BasicFeeType::getAllValues()[$data->basic_fee_type] }}<br>
初期費用合計金額：　{{ $data->initial_price }}<br>
月額料：　{{ $data->month_price }}<br>
@if($data->note)
備考（通信欄）：　{{ $data->note }}
@endif
=====================================================
@endcomponent
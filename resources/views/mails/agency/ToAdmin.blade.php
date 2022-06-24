@component('mail::message')
以下、ご入力いただいた申請内容です。
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
紹介取次店ID：　{{ $data->syoukai_id }}<br>
紹介取次店名：　{{ $data->syoukai_name }}<br>
エバンジェリストID：　{{ $data->eva_id }}<br>
エバンジェリスト名：　{{ $data->eva_name }}<br>
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
銀行名：　{{ $data->bank_name }}<br>
銀行コード：　{{ $data->bank_code }}<br>
支店名：　{{ $data->branch_name }}<br>
支店コード：　{{ $data->branch_code }}<br>
預金種目：　{{ $data->deposit->name }}<br>
口座番号：　{{ $data->account_number }}<br>
口座名義（ｶﾅ）：　{{ $data->account_name }}<br>
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
「特定商取引法に関する法律」第37条第1項及び第2項に定まる書類（概要書面）の交付について：　{{ \App\Enums\CommercialPrivacyType::getAllValues()[$data->commercial_privacy_type] }}<br>
@if($data->note)
備考（通信欄）：　{{ $data->note }}
@endif
=====================================================
@endcomponent
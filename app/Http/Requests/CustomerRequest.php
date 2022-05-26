<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\SexType;
use App\Enums\ContractType;
use App\Enums\DepositType;
use App\Enums\ShippingAddressType;
use App\Enums\InitialPaymentType;
use App\Enums\MonthlyPaymentType;
use App\Enums\PaymentNumberType;
use App\Enums\CardCompanyType;
use App\Enums\DesireContacType;
use App\Enums\DesireDateTimeType;
use App\Enums\BasicFeeType;
use App\Enums\CommercialPrivacyType;

class CustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'uuid' => 'required',
            'sex_type' => 'required|in:' . implode(",", SexType::ALL_OPTIONS),
            'kanji_sei' => 'required_if:sex_type,' . implode(",", array_diff(SexType::ALL_OPTIONS, [SexType::CORPORATION])),
            'kanji_mei' => 'required_if:sex_type,' . implode(",", array_diff(SexType::ALL_OPTIONS, [SexType::CORPORATION])),
            'kata_sei' => 'regex:/\A[ｦ-ﾟ]+\z/u|required_if:sex_type,' . implode(",", array_diff(SexType::ALL_OPTIONS, [SexType::CORPORATION])),
            'kata_mei' => 'regex:/\A[ｦ-ﾟ]+\z/u|required_if:sex_type,' . implode(",", array_diff(SexType::ALL_OPTIONS, [SexType::CORPORATION])),
            'corp_kanji' => 'required_if:sex_type,' . SexType::CORPORATION,
            'corp_kata' => 'regex:/\A[ｦ-ﾟ]+\z/u|required_if:sex_type,' . SexType::CORPORATION,
            'rep_kanji_sei' => 'required_if:sex_type,' . SexType::CORPORATION,
            'rep_kanji_mei' => 'required_if:sex_type,' . SexType::CORPORATION,
            'rep_kata_sei' => 'regex:/\A[ｦ-ﾟ]+\z/u|required_if:sex_type,' . SexType::CORPORATION,
            'rep_kata_mei' => 'regex:/\A[ｦ-ﾟ]+\z/u|required_if:sex_type,' . SexType::CORPORATION,
            'birthday' => 'required|date',
            'zip1' => 'required',
            'pref1' => 'required',
            'city1' => 'required',
            'addr1' => '',
            'home_phone' => 'required',
            'fax' => 'nullable',
            'mobile_phone' => 'required',
            'mobile_phone2' => 'nullable',
            'sinsei_email' => 'required|email:filter|max:255',
            'phone_email' => 'nullable|email:filter|max:255',
            'work_place_name' => 'required',
            'work_place_phone' => 'required',
            'contract_type' => 'required|in:' . implode(",", ContractType::ALL_OPTIONS),
            'shipping_address_type' => 'nullable|in:' . implode(",", ShippingAddressType::ALL_OPTIONS) . '|required_if:contract_type,' . ContractType::BULK,
            'zip2' => 'required_if:shipping_address_type,' . implode(",", array_diff(ShippingAddressType::ALL_OPTIONS, [ShippingAddressType::CURRENT])),
            'pref2' => 'required_if:shipping_address_type,' . implode(",", array_diff(ShippingAddressType::ALL_OPTIONS, [ShippingAddressType::CURRENT])),
            'city2' => 'required_if:shipping_address_type,' . implode(",", array_diff(ShippingAddressType::ALL_OPTIONS, [ShippingAddressType::CURRENT])),
            'addr2' => '',
            'receiver_name' => 'required_if:contract_type,' . ContractType::BULK,
            'receiver_phone' => 'nullable|required_if:contract_type,' . ContractType::BULK,
            
            'initial_payment_type'  => 'required|in:' . implode(",", InitialPaymentType::ALL_OPTIONS),
            'payment_number_type' => 'required_if:initial_payment_type,' . InitialPaymentType::CREDITCARD . '|nullable|in:' . implode(",", PaymentNumberType::ALL_OPTIONS),
            'card_company_type' => 'required_if:initial_payment_type,' . InitialPaymentType::CREDITCARD . '|nullable|in:' . implode(",", CardCompanyType::ALL_OPTIONS),
            'card_number' => 'required_if:initial_payment_type,' . InitialPaymentType::CREDITCARD . '|nullable|numeric|digits:6',
            'card_name' => 'required_if:initial_payment_type,' . InitialPaymentType::CREDITCARD . '|nullable|alpha_num',
            'expiration_date' => 'required_if:initial_payment_type,' . InitialPaymentType::CREDITCARD . '|nullable',
            'monthly_payment_type' => 'required|in:' . implode(",", MonthlyPaymentType::ALL_OPTIONS),
            
            'product_id' => 'required|exists:products,id',
            'bank_name' => 'required',
            'bank_code' => 'required',
            'branch_name' => 'required',
            'branch_code' => 'required',
            'deposit_id' => 'required|exists:deposits,id',
            'account_number' => 'required',
            'account_name' => 'required',
            'identity_doc' => 'required',

            'desire_month' => 'required',
            'desire_contact_type' => 'required|in:' . implode(",", DesireContacType::ALL_OPTIONS),
            'desire_datetime_type' => 'required|in:' . implode(",", DesireDateTimeType::ALL_OPTIONS),
            'desire_date' => 'required_if:desire_datetime_type,' . DesireDateTimeType::SPECIAL,
            'desire_start_h' => 'required_if:desire_datetime_type,' . DesireDateTimeType::SPECIAL,
            'desire_start_m' => 'required_if:desire_datetime_type,' . DesireDateTimeType::SPECIAL,
            'desire_end_h' => 'required_if:desire_datetime_type,' . DesireDateTimeType::SPECIAL,
            'desire_end_m' => 'required_if:desire_datetime_type,' . DesireDateTimeType::SPECIAL,
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'kanji_sei' => '姓',
            'kanji_mei' => '名',
            'kata_sei' => 'ｾｲ',
            'kata_mei' => 'ﾒｲ',
            'corp_kanji' => '法人名',
            'corp_kata' => 'ﾎｳｼﾞﾝﾒｲ',
            'rep_kanji_sei' => '代表者姓',
            'rep_kanji_mei' => '代表者名',
            'rep_kata_sei' => 'ﾀﾞｲﾋｮｳｼｬｾｲ',
            'rep_kata_mei' => 'ﾀﾞｲﾋｮｳｼｬﾒｲ',
            'sex_type' => '性別',
            'birthday' => '生年月日',
            'zip1' => '郵便番号',
            'pref1' => '都道府県',
            'city1' => '住所１（番地まで）',
            'addr1' => '住所２（マンション名・号室）',
            'home_phone' => '自宅電話番号',
            'fax' => 'FAX番号',
            'mobile_phone' => '携帯電話',
            'mobile_phone2' => '携帯電話（予備）',
            'sinsei_email' => 'メールアドレス',
            'phone_email' => 'メールアドレス（予備）',
            'work_place_name' => '勤務先名',
            'work_place_phone' => '勤務先電話番号',
            'contract_type' => '契約タイプ',
            'shipping_address_type' => '配送先指定',
            'zip2' => '郵便番号',
            'pref2' => '都道府県',
            'city2' => '住所１（番地まで）',
            'addr2' => '住所２（マンション名・号室）',
            'receiver_name' => '宛名',
            'receiver_phone' => '宛先電話番号',

            'initial_payment_type' => '初期費用支払方法',
            'payment_number_type' => '支払い回数',
            'card_company_type' => 'カード会社',
            'card_number' => 'カード番号',
            'card_name' => 'カード名義',
            'expiration_date' => '有効期限',
            'monthly_payment_type' => '月額料支払方法',

            'product_id' => '契約商品',
            'bank_name' => '銀行名',
            'bank_code' => '銀行コード',
            'branch_name' => '支店名',
            'branch_code' => '支店コード',
            'deposit_id' => '預金種目',
            'account_number' => '口座番号',
            'account_name' => '口座名義（ｶﾅ）',
            'identity_doc' => '本人確認書類',
            'identity_doc2' => '本人確認書類（予備）',
            
            'desire_month' => '希望登録月',
            'desire_contact_type' => '本人確認の希望連絡先',
            'desire_datetime_type' => '希望日時形式',
            'desire_date' => '希望日',
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'shipping_address_type.required_if' => '配送先指定は、必ず入力してください。',
            'zip2.required_if' => '郵便番号は、必ず入力してください。',
            'pref2.required_if' => '都道府県は、必ず入力してください。',
            'receiver_name.required_if' => '宛名は、必ず入力してください。',
            'receiver_phone.required_if' => '宛先電話番号は、必ず入力してください。',
            'kanji_sei.required_if' => '姓は、必ず入力してください。',
            'kanji_mei.required_if' => '名は、必ず入力してください。',
            'kata_sei.required_if' => 'ｾｲは、必ず入力してください。',
            'kata_mei.required_if' => 'ﾒｲは、必ず入力してください。',
            'corp_kanji.required_if' => '法人名は、必ず入力してください。',
            'corp_kata.required_if' => 'ﾎｳｼﾞﾝﾒｲは、必ず入力してください。',
            'rep_kanji_sei.required_if' => '代表者姓は、必ず入力してください。',
            'rep_kanji_mei.required_if' => '代表者名は、必ず入力してください。',
            'rep_kata_sei.required_if' => 'ﾀﾞｲﾋｮｳｼｬｾｲは、必ず入力してください。',
            'rep_kata_mei.required_if' => 'ﾀﾞｲﾋｮｳｼｬﾒｲは、必ず入力してください。',
            'city2.required_if' => '住所１（番地まで）は、必ず入力してください。',
            
            'payment_number_type.required_if' => '支払い回数は、必ず入力してください。',
            'card_company_type.required_if' => 'カード会社は、必ず入力してください。',
            'card_number.required_if' => 'カード番号は、必ず入力してください。',
            'card_name.required_if' => 'カード名義は、必ず入力してください。',
            'expiration_date.required_if' => '有効期限は、必ず入力してください。',
            'desire_date.required_if' => '日を指定してください。',
            'desire_start_h.required_if' => '時～を指定してください。',
            'desire_start_m.required_if' => '分～を指定してください。',
            'desire_end_h.required_if' => '～時を指定してください。',
            'desire_end_m.required_if' => '～分を指定してください。',
        ];
    }
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            checkPhone1($validator, 'home_phone', $this->input('home_phone'));
            checkPhone1($validator, 'fax', $this->input('fax'));
            checkPhone2($validator, 'mobile_phone', $this->input('mobile_phone'));
            checkPhone2($validator, 'mobile_phone2', $this->input('mobile_phone2'));
            checkPhone1($validator, 'work_place_phone', $this->input('work_place_phone'));
            checkPhone1($validator, 'receiver_phone', $this->input('receiver_phone'));
            if($this->input('agree') != 1) {
                $validator->errors()->add('agree', '上記すべて確認し、同意してください。');
            }
        });
    }
}

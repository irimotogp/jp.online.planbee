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

use App\Models\Product;

class AgencyRequest extends FormRequest
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
        $cashback_rule = "required";
        // if($product_id = $this->input('product_id')) {
        //     $product = Product::find($product_id);
        //     if($product->cashback == 1) {
        //         $cashback_rule = "required";
        //     }
        // }
        return [
            'sex_type' => 'required|in:' . implode(",", SexType::ALL_OPTIONS),
            'kanji_sei' => 'nullable|required_if:sex_type,' . implode(",", array_diff(SexType::ALL_OPTIONS, [SexType::CORPORATION])),
            'kanji_mei' => 'nullable|required_if:sex_type,' . implode(",", array_diff(SexType::ALL_OPTIONS, [SexType::CORPORATION])),
            'kata_sei' => 'nullable|regex:/\A[ｦ-ﾟ]+\z/u|required_if:sex_type,' . implode(",", array_diff(SexType::ALL_OPTIONS, [SexType::CORPORATION])),
            'kata_mei' => 'nullable|regex:/\A[ｦ-ﾟ]+\z/u|required_if:sex_type,' . implode(",", array_diff(SexType::ALL_OPTIONS, [SexType::CORPORATION])),
            'corp_kanji' => 'nullable|required_if:sex_type,' . SexType::CORPORATION,
            'corp_kata' => 'nullable|regex:/\A[ｦ-ﾟ()（）]+\z/u|required_if:sex_type,' . SexType::CORPORATION,
            'rep_kanji_sei' => 'nullable|required_if:sex_type,' . SexType::CORPORATION,
            'rep_kanji_mei' => 'nullable|required_if:sex_type,' . SexType::CORPORATION,
            'rep_kata_sei' => 'nullable|regex:/\A[ｦ-ﾟ]+\z/u|required_if:sex_type,' . SexType::CORPORATION,
            'rep_kata_mei' => 'nullable|regex:/\A[ｦ-ﾟ]+\z/u|required_if:sex_type,' . SexType::CORPORATION,
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
            'work_place_name' => 'required_if:sex_type,' . implode(",", array_diff(SexType::ALL_OPTIONS, [SexType::CORPORATION])),
            'work_place_phone' => 'required_if:sex_type,' . implode(",", array_diff(SexType::ALL_OPTIONS, [SexType::CORPORATION])),
            'contract_type' => 'required|in:' . implode(",", ContractType::ALL_OPTIONS),
            'shipping_address_type' => 'nullable|in:' . implode(",", ShippingAddressType::ALL_OPTIONS) . '|required_if:contract_type,' . ContractType::BULK,
            'zip2' => 'required_if:shipping_address_type,' . implode(",", array_diff(ShippingAddressType::ALL_OPTIONS, [ShippingAddressType::CURRENT])),
            'pref2' => 'required_if:shipping_address_type,' . implode(",", array_diff(ShippingAddressType::ALL_OPTIONS, [ShippingAddressType::CURRENT])),
            'city2' => 'required_if:shipping_address_type,' . implode(",", array_diff(ShippingAddressType::ALL_OPTIONS, [ShippingAddressType::CURRENT])),
            'addr2' => '',
            'receiver_name' => 'required_if:shipping_address_type,' . implode(",", array_diff(ShippingAddressType::ALL_OPTIONS, [ShippingAddressType::CURRENT])),
            'receiver_phone' => 'required_if:shipping_address_type,' . implode(",", array_diff(ShippingAddressType::ALL_OPTIONS, [ShippingAddressType::CURRENT])),
            
            'initial_payment_type'  => 'required|in:' . implode(",", InitialPaymentType::ALL_OPTIONS),
            'monthly_payment_type' => 'nullable|in:' . implode(",", MonthlyPaymentType::ALL_OPTIONS) . '|required_if:contract_type,' . implode(",", array_diff(ContractType::ALL_OPTIONS, [ContractType::BULK])),
            
            'payment_number_type' => 'required_if:monthly_payment_type,' . MonthlyPaymentType::CREDITCARD . '|required_if:initial_payment_type,' . InitialPaymentType::CREDITCARD . '|nullable|in:' . implode(",", PaymentNumberType::ALL_OPTIONS),
            'card_company_type' => 'required_if:monthly_payment_type,' . MonthlyPaymentType::CREDITCARD . '|required_if:initial_payment_type,' . InitialPaymentType::CREDITCARD . '|nullable|in:' . implode(",", CardCompanyType::ALL_OPTIONS),
            'card_number' => 'required_if:monthly_payment_type,' . MonthlyPaymentType::CREDITCARD . '|required_if:initial_payment_type,' . InitialPaymentType::CREDITCARD . '|nullable|numeric|digits:6',
            'card_name' => 'required_if:monthly_payment_type,' . MonthlyPaymentType::CREDITCARD . '|required_if:initial_payment_type,' . InitialPaymentType::CREDITCARD . '|nullable',
            'expiration_date' => 'required_if:monthly_payment_type,' . MonthlyPaymentType::CREDITCARD . '|required_if:initial_payment_type,' . InitialPaymentType::CREDITCARD . '|nullable|date_format:m/y',
            
            'product_id' => 'required|exists:products,id',
            'bank_name' => $cashback_rule,
            'bank_code' => $cashback_rule,
            'branch_name' => $cashback_rule,
            'branch_code' => $cashback_rule,
            'deposit_id' => $cashback_rule . '|exists:deposits,id',
            'account_number' => $cashback_rule . '|numeric|digits_between:1,7',
            'account_name' => $cashback_rule . '|regex:/\A[ｦ-ﾟ()（） ]+\z/u',
            'identity_doc' => 'required',

            'desire_month' => 'required',
            'desire_contact_type' => 'required|in:' . implode(",", DesireContacType::ALL_OPTIONS),
            'desire_datetime_type' => 'required|in:' . implode(",", DesireDateTimeType::ALL_OPTIONS),

            'desire_auth_month' => 'nullable|numeric|required_if:desire_datetime_type,' . DesireDateTimeType::SPECIAL,
            'desire_auth_day' => 'nullable|numeric|required_if:desire_datetime_type,' . DesireDateTimeType::SPECIAL,
            'desire_start_h' => 'nullable|numeric|required_if:desire_datetime_type,' . DesireDateTimeType::SPECIAL,
            'desire_start_m' => 'nullable|numeric|required_if:desire_datetime_type,' . DesireDateTimeType::SPECIAL,
            'desire_end_h' => 'nullable|numeric|required_if:desire_datetime_type,' . DesireDateTimeType::SPECIAL,
            'desire_end_m' => 'nullable|numeric|required_if:desire_datetime_type,' . DesireDateTimeType::SPECIAL,

            'product_option_ids' => 'nullable|array', 
            'commercial_privacy_type' => 'required',
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
            'commercial_privacy_type' => '「特定商取引法に関する法律」',
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
            'birthday.date' => '生年月日を選択してください。',
            'city2.required_if' => '住所１（番地まで）は、必ず入力してください。',

            'work_place_name.required_if' => '勤務先名は、必ず入力してください。',
            'work_place_phone.required_if' => '勤務先電話番号は、必ず入力してください。',
            
            'payment_number_type.required_if' => '支払い回数は、必ず入力してください。',
            'card_company_type.required_if' => 'カード会社は、必ず入力してください。',
            'card_number.required_if' => 'カード番号は、必ず入力してください。',
            'card_name.required_if' => 'カード名義は、必ず入力してください。',
            // 'card_name.regex' => 'カード名義は、英字（大文字半角）のみを入力してください。',
            'expiration_date.required_if' => '有効期限は、必ず入力してください。',
            'expiration_date.date_format' => '有効期限は、MM/YY形式で入力してください。',
            'monthly_payment_type.in' => '月額料支払方法を指定してください。',
            'monthly_payment_type.required_if' => '月額料支払方法を指定してください。',

            'desire_auth_month.required_if' => '月を指定してください。',
            'desire_auth_month.numeric' => '月を指定してください。',
            'desire_auth_day.required_if' => '日を指定してください。',
            'desire_auth_day.numeric' => '日を指定してください。',
            'desire_start_h.required_if' => '時～を指定してください。',
            'desire_start_h.numeric' => '時～を指定してください。',
            'desire_start_m.required_if' => '分～を指定してください。',
            'desire_start_m.numeric' => '分～を指定してください。',
            'desire_end_h.required_if' => '～時を指定してください。',
            'desire_end_h.numeric' => '～時を指定してください。',
            'desire_end_m.required_if' => '～分を指定してください。',
            'desire_end_m.numeric' => '～分を指定してください。',
        ];
    }
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            checkPhone($validator, 'home_phone', $this->input('home_phone'));
            checkPhone($validator, 'fax', $this->input('fax'));
            checkPhone($validator, 'work_place_phone', $this->input('work_place_phone'));
            checkPhone($validator, 'receiver_phone', $this->input('receiver_phone'));
            checkPhone11($validator, 'mobile_phone', $this->input('mobile_phone'));
            checkPhone11($validator, 'mobile_phone2', $this->input('mobile_phone2'));
            if($this->input('agree') != 1) {
                $validator->errors()->add('agree', '上記すべて確認し、同意してください。');
            }
            if($this->input('card_name')) {
                $card_name = $this->input('card_name');
                $card_name_filtered = str_replace(" ", "", $card_name);
                if(!preg_match('/\A[A-Z]+\z/u', $card_name_filtered) || (strlen($card_name_filtered) + 1 < strlen($card_name))) {
                    $validator->errors()->add('card_name', 'カード名義は、英字（大文字半角）のみを入力してください。');
                }
            }
        });
    }
}

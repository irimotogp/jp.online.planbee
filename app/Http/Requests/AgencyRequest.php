<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\SexType;
use App\Enums\ContractType;
use App\Enums\DepositType;
use App\Enums\ShippingAddressType;

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
        return [
            'uuid' => 'required',
            'kanji_sei' => 'required|regex:/\A[一-龥]+\z/',
            'kanji_mei' => 'required|regex:/\A[一-龥]+\z/',
            'kata_sei' => 'required|regex:/\A[ｦ-ﾟ]+\z/u',
            'kata_mei' => 'required|regex:/\A[ｦ-ﾟ]+\z/u',
            'sex_type' => 'required|in:' . implode(",", SexType::ALL_OPTIONS),
            'birthday' => 'required|date',
            'zip1' => 'required',
            'pref1' => 'required',
            'city1' => '',
            'addr1' => '',
            'home_phone' => 'nullable|numeric|digits:11',
            'fax' => 'required|numeric|digits:11',
            'mobile_phone' => 'nullable|numeric|digits:11',
            'mobile_phone2' => 'required|numeric|digits:11',
            'pc_email' => 'required|email:filter|max:255',
            'phone_email' => 'required|email:filter|max:255',
            'work_place_name' => 'required',
            'shipping_address_type' => 'nullable|in:' . implode(",", ShippingAddressType::ALL_OPTIONS) . '|required_if:contract_type,' . ContractType::BULK,
            'zip2' => 'required_if:shipping_address_type,' . implode(",", array_diff(ShippingAddressType::ALL_OPTIONS, [ShippingAddressType::CURRENT])),
            'pref2' => 'required_if:shipping_address_type,' . implode(",", array_diff(ShippingAddressType::ALL_OPTIONS, [ShippingAddressType::CURRENT])),
            'city2' => '',
            'addr2' => '',
            'receiver_name' => 'required_if:contract_type,' . ContractType::BULK,
            'receiver_phone' => 'nullable|numeric|digits:11|required_if:contract_type,' . ContractType::BULK,
            'contract_type' => 'required|in:' . implode(",", ContractType::ALL_OPTIONS),
            'product_id' => 'required|exists:products,id',
            'bank_name' => 'required',
            'bank_code' => 'required',
            'branch_name' => 'required',
            'branch_code' => 'required',
            'deposit_id' => 'required|exists:deposits,id',
            'account_number' => 'required',
            'identity_doc' => 'required'
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
            'pc_email' => 'PCメール',
            'phone_email' => '携帯メール',
            'work_place_name' => '勤務先名',
            'shipping_address_id' => '配送先指定',
            'zip2' => '郵便番号',
            'pref2' => '都道府県',
            'city2' => '住所１（番地まで）',
            'addr2' => '住所２（マンション名・号室）',
            'receiver_name' => '宛名',
            'receiver_phone' => '宛先電話番号',
            'contract_type' => '契約タイプ',
            'product_id' => '契約商品',
            'bank_name' => '銀行名',
            'bank_code' => '銀行コード',
            'branch_name' => '支店名',
            'branch_code' => '支店コード',
            'deposit_id' => '預金種目',
            'account_number' => '口座番号',
            'identity_doc' => '本人確認書類',
            'identity_doc2' => '本人確認書類（予備）',
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
        ];
    }
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if(empty($this->input('home_phone')) && empty($this->input('mobile_phone'))) {
                $validator->errors()->add('phone_any', '自宅番号もしくは携帯番号を入力してください。');
            }
        });
    }
}

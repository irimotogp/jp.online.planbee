<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\SexType;
use App\Enums\ContractType;
use App\Enums\DepositType;

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
            'kanji_sei' => 'required',
            'kanji_mei' => 'required',
            'kata_sei' => 'required',
            'kata_mei' => 'required',
            'sex_type' => 'required|in:' . implode(",", SexType::ALL_OPTIONS),
            'birthday' => 'required|date',
            'zip1' => 'required',
            'pref1' => 'required',
            'city1' => '',
            'addr1' => '',
            'home_phone' => 'required|numeric|digits:10',
            'fax' => 'required|numeric|digits:10',
            'mobile_phone' => 'required|numeric|digits:10',
            'mobile_phone2' => 'required|numeric|digits:10',
            'pc_email' => 'required|email:filter|max:255',
            'phone_email' => 'required|email:filter|max:255',
            'work_place_name' => 'required',
            'shipping_address_id' => 'required|exists:shipping_addresses,id',
            'zip2' => 'required',
            'pref2' => 'required',
            'city2' => '',
            'addr2' => '',
            'receiver_name' => 'required',
            'receiver_phone' => 'required|numeric|digits:10',
            'syoukai_id' => 'required',
            'syoukai_name' => 'required',
            'eva_id' => 'required',
            'eva_name' => 'required',
            'contract_type' => 'required|in:' . implode(",", ContractType::ALL_OPTIONS),
            'product_id' => 'required|exists:products,id',
            'bank_name' => 'required',
            'bank_code' => 'required',
            'branch_name' => 'required',
            'branch_code' => 'required',
            'deposit_id' => 'required|exists:deposits,id',
            'account_number' => 'required',
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
            'syoukai_id' => '紹介取次店ID',
            'syoukai_name' => '紹介取次店名',
            'eva_id' => 'エバンジェリストID',
            'eva_name' => 'エバンジェリスト名',
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
        ];
    }
}

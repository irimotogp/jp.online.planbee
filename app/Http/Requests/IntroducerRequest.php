<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\IntroducerType;
use App\Enums\NthType;
use App\Enums\ISDType;
use App\Enums\WEGType;
use App\Enums\DirectionType;

class IntroducerRequest extends FormRequest
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
            'sinsei_name' => 'required|max:255',
            'sinsei_email' => 'required|email:filter|max:255',
            'introducer_type' => 'required|in:' . implode(",", IntroducerType::ALL_OPTIONS),
            'syoukai_id' => 'required|numeric|digits:10',
            'syoukai_name' => 'required',
            'eva_id' => 'nullable|numeric|digits:10',
            'eva_name' => '',
            'nth_type' => 'required|in:' . implode(",", NthType::ALL_OPTIONS),
            'isd_type' => 'required|in:' . implode(",", ISDType::ALL_OPTIONS),
            'isd_id' => 'required_if:isd_type,' . ISDType::DESIGNATE,
            'isd_name' => 'required_if:isd_type,' . ISDType::DESIGNATE,
            'direction_type' => 'required_if:isd_type,' . ISDType::DESIGNATE . "|nullable|in:" . implode(",", DirectionType::ALL_OPTIONS),
            'weg_type' => 'required|in:' . implode(",", WEGType::ALL_OPTIONS),
            'note' => ''
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
            'sinsei_name' => '登録申請者氏名',
            'sinsei_email' => '登録申請者メールアドレス',
            'introducer_type' => 'タイプ',
            'syoukai_id' => '紹介取次店ID',
            'syoukai_name' => '紹介取次店名',
            'eva_id' => 'エバンジェリストID',
            'eva_name' => 'エバンジェリスト名',
            'nth_type' => 'Nth人目',
            'isd_type' => '直上者指定',
            'isd_id' => '直上者ID',
            'isd_name' => '直上者名',
            'direction_type' => '直上者の',
            'weg_type' => '電解水生成器',
            'note' => '備考（通信欄）'
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
            'type.required' => '必ず選択してください。',
            'nth.required' => '必ず選択してください。',
            'isd.required' => '必ず選択してください。',
            'eva_id.required' => 'エバンジェリストIDを指定してください。',
            'eva_name.required_if' => 'エバンジェリストIDを指定してください。',
            'isd_id.required_if' => '直上者IDを指定してください。',
            'isd_name.required_if' => '直上者名を指定してください。',
            'direction_type.required_if' => '直上者の左や右を指定してください。',
            'direction_type.in' => '直上者の左や右を指定してください。',
        ];
    }
}

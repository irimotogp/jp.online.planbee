<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\IntroducerType;
use App\Enums\NthType;
use App\Enums\ISDType;

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
            'syoukai_id' => 'required',
            'syoukai_name' => 'required',
            'eva_id' => 'required',
            'eva_name' => 'required',
            'nth_type' => 'required|in:' . implode(",", NthType::ALL_OPTIONS),
            'isd_type' => 'required|in:' . implode(",", ISDType::ALL_OPTIONS),
            'isd_id' => 'required',
            'isd_name' => 'required',
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
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FangRequest extends FormRequest
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
            //
            'fang_province'=>'required|numeric|min:1'
        ];
    }
    public function messages()
    {
        return [
            'fang_province.required'=>'省份必须选择',
            'fang_province.min'=>'选择一下省份',
        ];
    }
}

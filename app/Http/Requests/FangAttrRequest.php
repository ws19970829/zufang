<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
//用于自定义验证规则类
use Validator;
use Illuminate\Http\Request;

class FangAttrRequest extends FormRequest
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
        $this->fieldName();
        return [
            'name'=>'required',
            'field_name'=>'fieldname'
        ];
    }
    public function messages(){
        return [
            'field_name.fieldname'=>'选择顶级属性请一定要填写对应的字段名称',
        ];
    }
    public function fieldName(){
        Validator::extend('fieldname',function ($attribute,$value,$parameters,$validator){
            $pid = request()->get('pid');
            $bool = $pid == 0 ?false:true;
            $reg='/\w+/';
            return $bool || preg_match($reg,$value);
        });
    }
}

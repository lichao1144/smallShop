<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserPost extends FormRequest
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
            'u_name'=>'required|unique:user|max:4|min:2',
            'u_age'=>'required|integer',
        ];
    }

    public function messages(){
        return [
            'u_name.required'=>'姓名不能为空',
            'u_name.unique'=>'姓名已存在',
            'u_name.max'=>'姓名最大为4位',
            'u_name.min'=>'姓名最小为2位',
            'u_age.required'=>'年龄不能为空',
            'u_age.integer'=>'年龄应为整数',
        ];
    }
}

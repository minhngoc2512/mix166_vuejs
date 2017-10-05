<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserLoginCmsRequest extends FormRequest
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
            'name'=>'required',
            'email'=>'required',
            'password'=>'required|min:6',
            'repeatpassword'=>'required|min:6|same:password'
            //
        ];
    }
    public function messages()
    {
        return [
            'name.required'=>'Vui lòng nhập tên người dùng',
            'email.required'=>'Vui lòng nhập địa chỉ email của bạn',
            'repeatpassword.required'=>'Vui lòng nhập lại mật khẩu của bạn',
            'password.required'=>'Vui lòng nhập mật khẩu của bạn',
            'repeatpassword.same'=>'Mật khẩu nhập lại không đúng',
            'password.min'=>'Mật khẩu quá ngắn',
            'repeatpassword.min'=>'Mật khẩu nhập lại quá ngắn'

        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserRequest extends FormRequest
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
            'name' => 'required|between:3,25|regex:/^[A-Za-z0-9\-\_]+$/',
            'email' => 'required|email',
            'introduction' => 'max:80',
            'avatar' => 'mimes:png,jpg,gif,jpeg|dimensions:min_width=208,min_height=208'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '用户名必须填写',
            'name.between' => '用户名字段大小必须在3-25个字符',
            'name.regex' => '用户名只支持英文、数字、横杠和下划线',
            'email.required' => '邮箱必须填写',
            'email.email' => '邮箱格式不正确',
            'introduction.max' => '个人简介不得超过80字符',
            'avatar.mimes' => '头像必须是 png, jpg, gif, jpeg 格式的图片',
            'avatar.dimensions' => '图片的清晰度不够，宽和高需要 208px 以上',
        ];
    }
}

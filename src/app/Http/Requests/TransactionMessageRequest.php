<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionMessageRequest extends FormRequest
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
            'message' => 'required|max:400',
            'image_url' => 'nullable|mimes:jpeg,png,jpg,|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'message.required' => 'お名前を入力してください',
            'message.max' => 'お名前は20文字以内で入力してください',
            'image_url.mimes' => 'アップロード可能なファイル形式は、.jpeg .jpg .pngです',
            'image_url.max' => 'アップロード可能なファイルのサイズは2MB以内です',
        ];
    }
}

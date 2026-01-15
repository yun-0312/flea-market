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
            'new_message' => 'required|max:400',
            'image' => 'nullable|file|mimes:jpeg,png|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'new_message.required' => '本文を入力してください',
            'new_message.max' => '本文は400文字以内で入力してください',
            'image.mimes' => '「.png」または「.jpeg」形式でアップロードしてください',
            'image.max' => 'アップロード可能なファイルのサイズは2MB以内です',
        ];
    }
}
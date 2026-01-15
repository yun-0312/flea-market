<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class UpdateTransactionMessageRequest extends FormRequest
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

    public $errorBag = 'updateMessage';

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            redirect()
                ->back()
                ->withErrors($validator, $this->errorBag)
                ->with('updated_message_id', $this->route('message')->id)
                ->withInput()
        );
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
            'image' => 'nullable|file|mimes:jpeg,png|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'message.required' => '本文を入力してください',
            'message.max' => '本文は400文字以内で入力してください',
            'image.mimes' => '「.png」または「.jpeg」形式でアップロードしてください',
            'image.max' => 'アップロード可能なファイルのサイズは2MB以内です',
        ];
    }
}
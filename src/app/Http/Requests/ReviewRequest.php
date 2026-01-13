<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
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
            'comment' => 'required|max:255',
            'rating' => 'required|integer|between:1,5',
        ];
    }

    public function messages()
    {
        return [
            'comment.required' => '本文を入力してください',
            'comment.max' => '本文は400文字以内で入力してください',
            'rating.required' => '評価を選択してください',
            'rating.between' => '評価は★1～5で選んでください'
        ];
    }
}

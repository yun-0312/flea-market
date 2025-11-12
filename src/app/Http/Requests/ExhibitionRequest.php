<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
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
            'image_url' => 'required|mimes:jpeg,png,jpg,|max:2048',
            'condition' => 'required',
            'name' => 'required',
            'brand' => 'nullable',
            'description' => 'required|max:255',
            'price' => 'required|integer|min:0',
            'categories' => 'required|array'
        ];
    }

    public function messages()
    {
        return [
            'image_url.required' => '商品画像をアップロードしてください',
            'image_url.mimes' => 'アップロード可能なファイル形式は、.jpeg .jpg .pngです',
            'image_url.max' => 'アップロード可能なファイルのサイズは2MB以内です',
            'condition.required' => '商品の状態を選択してください',
            'name.required' => '商品名を入力してください',
            'description.required' => '商品の説明を入力してください',
            'description.max' => '商品の説明は255文字以内で入力してください',
            'price.required' => '販売価格を入力してください',
            'price.integer' => '販売価格は整数で入力してください',
            'price.min' => '販売価格は0円以上で入力してください',
            'categories.required' => 'カテゴリーを選択してください',
            'categories.array' => 'カテゴリーの形式が正しくありません',
            'categories.min' => 'カテゴリーを少なくとも1つ選択してください'
        ];
    }
}

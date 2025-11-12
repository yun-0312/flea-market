<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
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
            'payment_method' => 'required',
        ];
    }

        public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $user = auth()->user();
            $sessionAddress = session('shipping_address');
            $profile = $user->profile;
            // 配送先が未設定の場合
            $hasSessionAddress = $sessionAddress && !empty($sessionAddress['post_code']) && !empty($sessionAddress['address']);
            $hasProfileAddress = $profile && !empty($profile->post_code) && !empty($profile->address);

            if (!$hasSessionAddress && !$hasProfileAddress) {
                $validator->errors()->add('shipping_address_id', '配送先を登録してください');
            }
        });
    }

    public function messages()
    {
        return [
            'payment_method.required' => '支払い方法を選択してください'
        ];
    }
}

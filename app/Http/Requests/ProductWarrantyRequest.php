<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductWarrantyRequest extends FormRequest
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
            'price1'=>'required|numeric',
            'price2'=>'required|numeric',
            'sendTime'=>'required|numeric',
        ];
    }

    public function attributes()
    {
        return [
            'price1'=>'قیمت محصول',
            'price2'=>'قیمت محصول برای فروش',
            'sendTime'=>'زمان ارسال محصول',
        ];
    }

    public function messages()
    {
        return [
            'price1.numeric'=>'قیمت محصول باید به صورت عددی باشد',
            'price2.numeric'=>'قیمت محصول برای فروش باید به صورت عددی باشد',
            'sendTime.numeric'=>'زمان ارسال محصول باید به صورت عددی باشد',
        ];
    }
}

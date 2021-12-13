<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'title'=>'required',
            'category_id'=>'required',
            'brand_id'=>'required',
            'description'=>'required',
            'product_color'=>'required'
        ];
    }

    public function attributes()
    {
        return [
            'title'=>'عنوان محصول',
            'category_id'=>'دسته محصول',
            'brand_id'=>'برند محصول',
            'description'=>'توضیحات محصول',
            'product_color'=>'رنگ محصول',
        ];
    }
}

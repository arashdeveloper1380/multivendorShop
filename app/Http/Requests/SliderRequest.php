<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SliderRequest extends FormRequest
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
            'url'=>'required',
            'image_url'=>'image|required'
        ];
    }
    public function attributes()
    {
        return [
            'title'=>'عنوان اسلایدر',
            'url'=>'لینک اسلایدر',
            'image_url'=>'تصویر اسلایدر'
        ];
    }
}

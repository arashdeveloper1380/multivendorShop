<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
        $array = [
            'name'=>'required|max:255',
            'image'=>'image'
        ];
        if(empty($this->request->get('ename'))){
            $array['search_url'] = 'required';
        }else{
            $array['ename']='unique:categories,ename'.$this->categories;
        }
        return $array;
    }

    public function attributes()
    {
        return [
            'name'=>'نام دسته',
            'ename'=>'نام لایتن دسته',
            'search_url'=>'لینک دسته',
            'image'=>'تصویر دسته'
        ];
    }

    public function messages()
    {
        return [
            'search_url.required'=>'برای دسته نام لاتین یا لینک دسته ثبت شود'
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
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
            'name' => 'required',
            'price'=> 'required|numeric|integer|min:0',
            'category_id' => 'required|integer',
            'photo' => 'required|image|mimes:jpg,jpeg|max:512'
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'price' => round(intval($this->price) * 100),
            'category_id' => intval($this->category)
        ]);
    }
}
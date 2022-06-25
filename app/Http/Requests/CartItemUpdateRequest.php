<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CartItemUpdateRequest extends FormRequest
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
            'product_id' => 'required|integer|exists:App\Models\Product,id'
        ];
    }

    public function messages()
    {
        return [
            'product_id.exists' => 'The selected product is not found.'
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'product_id' => $this->product
        ]);
    }

}

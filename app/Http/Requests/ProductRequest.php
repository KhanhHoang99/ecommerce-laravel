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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'price' => 'required',
            'company' => 'required',
            'id_category' => 'required|exists:categories,id',
            'id_brand' => 'required|exists:brands,id',
            'quantity' => 'nullable|numeric|min:0', // Assuming quantity is optional
            'detail' => 'nullable|string',
            'files.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validate each uploaded image
        ];
    }
}

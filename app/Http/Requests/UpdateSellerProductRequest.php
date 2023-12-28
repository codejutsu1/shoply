<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSellerProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => "required",
            "description" => "required",
            "quantity" => "required|integer|min:1",
            "image" => "image",
            "status" => "in:" . Product::AVAILABLE_PRODUCT . ',' . Product::UNAVAILABLE_PRODUCT,
        ];
    }
}
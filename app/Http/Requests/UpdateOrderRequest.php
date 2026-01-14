<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => 'required|in:confirmed,cancelled',
            'products' => ['sometimes', 'array', 'min:1'],
            'products.*.name' => ['required_with:products', 'string', 'max:255'],
            'products.*.quantity' => ['required_with:products', 'integer', 'min:1'],
            'products.*.price' => ['required_with:products', 'numeric', 'gt:0'],
        ];
    }
}

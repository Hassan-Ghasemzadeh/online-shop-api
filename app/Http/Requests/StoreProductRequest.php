<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        //$this->user()->can('create', Product::class);
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     */
    public function rules(): array
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:100|unique:products,sku',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean'
        ];
    }
}

<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreInventoryRequest extends FormRequest
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
            'type' => ['required', Rule::in(['add', 'remove'])],
            'products' => ['required', 'array'],
            'products.*.product_id' => ['required', 'exists:products,id'],
            'products.*.quantity' => ['required', 'integer', 'min:1'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->type === 'remove') {
                foreach ($this->products as $product) {
                    $productModel = Product::findOrFail($product['product_id']);
                    if ($productModel && $productModel->stock_quantity < $product['quantity']) {
                        $validator->errors()->add(__('Products'). '.' . $product['product_id'], __('The quantity exceeds the current stock for product ID ') . $product['product_id']);
                    }
                }
            }
        });
    }
}

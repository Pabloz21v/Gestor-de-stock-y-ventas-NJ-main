<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PedidoRequest extends FormRequest
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
            'product_id' => 'required|exists:products,id',
            'stock_real' => 'nullable|integer|min:0',
            'stock_en_viaje' => 'nullable|integer|min:0',
            'stock_en_viaje_vendido' => 'nullable|integer|min:0',
            'proveedor' => 'nullable|string|max:255',
            // 'web' => 'nullable|string|max:255',
            'web' => 'nullable|url|max:255'
        ];
    }
}

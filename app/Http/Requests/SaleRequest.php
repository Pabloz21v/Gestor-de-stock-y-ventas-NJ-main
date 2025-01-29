<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'reg' => 'required|string|max:255',
            'cliente' => 'required|string|max:255',
            'contacto' => 'nullable|string|max:255',
            'vendedor' => 'required|exists:users,id',
            'producto' => 'required|exists:products,id',
            'precio' => 'required|numeric|min:0',
            'unidades' => 'required|integer|min:1',
            'entrada' => 'nullable|numeric|min:0',
            'pendiente' => 'nullable|numeric|min:0',
            'sub_total' => 'required|numeric|min:0',
            'estado' => 'required|string|in:ENTREGADO,PENDIENTE,CANCELADO,EN_PREPARACION,VERIFICANDO,CONSIGNA',
            'sobreprecio' => 'nullable|numeric|min:0',
            'observacion' => 'nullable|string|max:255',
        ];
    }
}

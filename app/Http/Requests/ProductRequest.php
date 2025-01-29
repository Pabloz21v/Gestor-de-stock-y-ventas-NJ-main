<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class ProductRequest extends FormRequest
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
            'category_id' => 'nullable',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'visible' => 'boolean',
            'price' => 'numeric|min:0',
            'ganancia' => 'nullable|numeric|min:0',
            'descuento' => 'nullable|numeric',
            'oferta' => 'boolean',
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
            'detalles' => 'nullable|string',
            'marca' => 'nullable|string',
            'tamaño' => 'nullable|string',
            'color' => 'nullable|string',
            'peso' => 'nullable|string',
            'dimensiones' => 'nullable|string',
            'stock' => 'integer',
            'contador_ventas' => 'integer',
            'stock_real' => 'integer|min:0',
            'stock_minimo' => 'integer',
            'stock_maximo' => 'integer',
            'imagen_principal' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'imagenes.*' =>  'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'video' => 'nullable|mimes:mp4|max:20480',
            'proveedores' => 'nullable',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            // 'subcategory_id.required' => 'La subcategoría es obligatoria.',

            // 'name.required' => 'El nombre del producto es obligatorio.',
            // 'name.string' => 'El nombre del producto debe ser una cadena de texto.',
            // 'name.max' => 'El nombre del producto no puede tener más de 255 caracteres.',

            // 'description.string' => 'Los productos deben ser una cadena de texto.',
            // 'description.max' => 'Los productos no pueden tener más de 255 caracteres.',

            // 'price.required' => 'El precio del producto es obligatorio.',
            // 'price.numeric' => 'El precio del producto debe ser un número.',
            // 'price.min' => 'El precio del producto debe ser un número positivo.',

            // 'visible.boolean' => 'El valor de visibilidad debe ser verdadero o falso.',
        ];
    }
}

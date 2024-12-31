<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DisheRequest extends FormRequest
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
            'subcategory_id' => 'required|exists:subcategories,id',
            'name' => 'required|string|max:255',
            'ingredients' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'visible' => 'boolean',
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
            'subcategory_id.required' => 'La subcategoría es obligatoria.',
            
            'name.required' => 'El nombre del plato es obligatorio.',
            'name.string' => 'El nombre del plato debe ser una cadena de texto.',
            'name.max' => 'El nombre del plato no puede tener más de 255 caracteres.',
            
            'ingredients.string' => 'Los ingredientes deben ser una cadena de texto.',
            'ingredients.max' => 'Los ingredientes no pueden tener más de 255 caracteres.',
            
            'price.required' => 'El precio del plato es obligatorio.',
            'price.numeric' => 'El precio del plato debe ser un número.',
            'price.min' => 'El precio del plato debe ser un número positivo.',
            
            'visible.boolean' => 'El valor de visibilidad debe ser verdadero o falso.',
        ];
    }
}

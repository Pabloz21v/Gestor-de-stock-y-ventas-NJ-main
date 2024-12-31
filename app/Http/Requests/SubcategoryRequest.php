<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubcategoryRequest extends FormRequest
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
            'categories_id' => 'required|exists:categories,id',
            'name' => 'nullable|string|max:255',
            'comment' => 'nullable|string|max:300',
            'orden' => 'required|integer|min:0',
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
            'categories_id.required' => 'La categoría es obligatoria.',
            
            'name.string' => 'El nombre de la subcategoría debe ser una cadena de texto.',
            'name.max' => 'El nombre de la subcategoría no puede tener más de 255 caracteres.',
            
            'comment.string' => 'El comentario debe ser una cadena de texto.',
            'comment.max' => 'El comentario no puede tener más de 300 caracteres.',
            
            'orden.required' => 'El orden de la subcategoría es obligatorio.',
            'orden.integer' => 'El orden de la subcategoría debe ser un número entero.',
            'orden.min' => 'El orden de la subcategoría debe ser un número positivo.',
            
            'visible.boolean' => 'El campo de visibilidad debe ser verdadero o falso.',
        ];
    }
}


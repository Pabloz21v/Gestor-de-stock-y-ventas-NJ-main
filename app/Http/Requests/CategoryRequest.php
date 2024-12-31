<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'name' => 'required|string|max:255',
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
            'name.required' => 'El nombre de la categoría es obligatorio.',
            'name.string' => 'El nombre de la categoría debe ser una cadena de texto.',
            'name.max' => 'El nombre de la categoría no puede tener más de 255 caracteres.',
            
            'comment.string' => 'El comentario debe ser una cadena de texto.',
            'comment.max' => 'El comentario no puede tener más de 300 caracteres.',
            
            'orden.required' => 'El orden de la categoría es obligatorio.',
            'orden.integer' => 'El orden de la categoría debe ser un número entero.',
            'orden.min' => 'El orden de la categoría debe ser un número positivo.',
            
            'visible.boolean' => 'El campo de visibilidad debe ser verdadero o falso.',
        ];
    }
}

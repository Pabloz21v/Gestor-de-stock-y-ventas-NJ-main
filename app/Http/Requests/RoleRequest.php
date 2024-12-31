<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoleRequest extends FormRequest
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
        $userId = $this->route('role');

        return [
            'name' => ['required', 'string', 'max:30', 'regex:/^[^\d]*$/'],
            'apellido' => ['required', 'string', 'max:30', 'regex:/^[^\d]*$/'],
            'phone' => ['nullable', 'numeric', 'digits_between:0,20'],
            'domicilio' => ['nullable', 'max:200'],
            'comentarios'=> ['nullable', 'max:300'],
            'email' => [
                'required',
                Rule::unique('users')->ignore($userId),
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[a-z]/',      // debe contener al menos una letra minúscula
                'regex:/[A-Z]/',      // debe contener al menos una letra mayúscula
                'regex:/[0-9]/',      // debe contener al menos un número
                'regex:/[@$!%*#?&]/'  // debe contener al menos un carácter especial
            ],
            'cargo' => ['required', 'string', 'max:35'],
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
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser una cadena de texto.',
            'name.max' => 'El nombre no puede tener más de 30 caracteres.',
            'name.regex' => 'El nombre no puede contener números.',

            'apellido.required' => 'El apellido es obligatorio.',
            'apellido.string' => 'El apellido debe ser una cadena de texto.',
            'apellido.max' => 'El apellido no puede tener más de 30 caracteres.',
            'apellido.regex' => 'El apellido no puede contener números.',

            'phone.numeric' => 'El teléfono debe ser un número.',
            'phone.digits_between' => 'El teléfono no puede tener más de 20 dígitos.',

            'domicilio.max' => 'El domicilio no puede tener más de 200 caracteres.',

            'comentarios.max' => 'Los comentarios no pueden tener más de 300 caracteres.',

            'email.required' => 'El correo electrónico es obligatorio.',
            'email.unique' => 'Este correo electrónico ya existe en el sistema.',

            'password.required' => 'La contraseña es obligatoria.',
            'password.string' => 'La contraseña debe ser una cadena de texto.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.regex' => 'La contraseña debe contener al menos una letra mayúscula, una letra minúscula, un número y un carácter especial.',
            
            'cargo.required' => 'El cargo es obligatorio.',
            'cargo.string' => 'El cargo debe ser una cadena de texto.',
            'cargo.max' => 'El cargo no puede tener más de 35 caracteres.',
        ];
    }
}

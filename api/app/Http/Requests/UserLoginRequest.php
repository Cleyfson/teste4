<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserLoginRequest extends FormRequest
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
        'email' => 'required|email',
        'password' => 'required|string|min:6',
      ];
    }

    /**
     * Customize the error messages.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
          'email.required' => 'O e-mail é obrigatório.',
          'email.email' => 'O e-mail deve ser válido.',
          'password.required' => 'A senha é obrigatória.',
          'password.min' => 'A senha deve ter pelo menos 6 caracteres.',
        ];
    }
}

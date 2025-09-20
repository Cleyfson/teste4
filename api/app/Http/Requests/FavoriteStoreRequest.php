<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FavoriteStoreRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool
  {
    return true; // Change this if you need authorization logic
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
   */
  public function rules(): array
  {
    return [
      'movie_id' => 'required|integer',
    ];
}

  /**
   * Get custom messages for validator errors.
   *
   * @return array<string, string>
   */
  public function messages(): array
  {
    return [
      'movie_id.required' => 'O ID do filme é obrigatório.',
      'movie_id.integer' => 'O ID do filme deve ser um número inteiro.',
      'movie_title.required' => 'O título do filme é obrigatório.',
      'movie_title.string' => 'O título do filme deve ser um texto.',
      'genre_ids.required' => 'Os gêneros do filme são obrigatórios.',
      'genre_ids.array' => 'Os gêneros devem ser enviados como uma lista.',
    ];
  }
}
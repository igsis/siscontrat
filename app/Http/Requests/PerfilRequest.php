<?php

namespace siscontrat\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PerfilRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
          'descricao' => 'required|max:30|min:3'          
        ];
    }

    public function messages()
    {
      return 
        [
          'descricao.required' => "O campo :attribute não pode ficar em branco",
          'descricao.min' => "O campo :attribute deve ter ao menos 3 caracteres",
          'descricao.max' => "O campo :attribute tem um limite de 30 caracteres"
        ];      
    }
}

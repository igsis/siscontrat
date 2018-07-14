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
        'descricao' => 'required|max:30|min:3|unique:perfis'        
      ];
    }

    public function messages()
    {
      return [        
        'required' => "O campo :attribute é obrigatório",
        'min' => "O campo :attribute deve ter ao menos 3 caracteres",
        'max' => "O campo :attribute tem um limite de 30 caracteres",
        'descricao.unique' => 'Já existe um perfil com esta descrição'
      ];      
    }
}

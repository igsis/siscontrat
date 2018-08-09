<?php

namespace siscontrat\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InstituicaoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    
    public function rules()
    {
      return [
        'nome' =>  'required|max:60|min:3|unique:instituicoes',
        'sigla' => 'required|max:8|min:3|unique:instituicoes',        
      ];
    }

    public function messages()
    {
      return [        
        'required' => "O campo :attribute é obrigatório",
        'min' => "O campo :attribute deve ter ao menos 3 caracteres",
        'nome.max' => "O campo :attribute tem um limite de 60 caracteres",
        'sigla.max' => "O campo :attribute tem um limite de 8 caracteres",
        'nome.unique' => 'Já existe uma instituição com este nome',
        'sigla.unique' => 'Já existe uma sigla com este nome'
      ];      
    }
}

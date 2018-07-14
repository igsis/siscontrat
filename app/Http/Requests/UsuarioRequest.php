<?php

namespace siscontrat\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioRequest extends FormRequest
{
    public function authorize()
    {
      return true;
    }

    public function rules()
    {
      return [        
        'nome_completo' => 'required|min:3|max:70',
        'usuario' => 'required|min:7|max:7|unique:usuarios',
        'senha' => 'required|min:6|max:8'      
      ];
    }

    public function messages()
    {
       return [
         'required' => "O campo :attribute é obrigatório",         
         
         'nome_completo.min' => 
           "O campo :attribute deve ter ao menos 3 caracteres",
         
         'nome_completo.max' => 
           "O campo :attribute tem um limite de 70 caracteres",

         'usuario.min' => 
           "O campo :attribute deve ter ao menos 7 caracteres",
         
         'usuario.max' => 
           "O campo :attribute tem um limite de 7 caracteres", 

         'usuario.unique' => 'Já existe um usuário com este nome',   

         'senha.min' => 
           "O campo :attribute deve ter ao menos 6 caracteres",
         
         'senha.max' => 
           "O campo :attribute tem um limite de 8 caracteres"
       ];
    }
}

<?php

namespace siscontrat\Http\Controllers;

use Request;
use siscontrat\Http\Controllers\Controller;
use siscontrat\Models\Usuario;
use siscontrat\Models\Perfil;


class UsuarioController extends Controller
{  

  public function criar()
  {
    return view("usuario.criar")
      ->with('perfils', Perfil::orderBy('descricao')->get()); 

  }    

  public function salvar()
  {      
    Usuario::create(Request::all());    
  }

  
}

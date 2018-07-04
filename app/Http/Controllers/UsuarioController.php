<?php

namespace siscontrat\Http\Controllers;

use Illuminate\Http\Request;
use siscontrat\Http\Controllers\Controller;

class UsuarioController extends Controller
{  

  public function criar()
  {
    return view("usuario.criar");
  }    

  public function salvar()
  {
  	return "salvar";
  }

  
}

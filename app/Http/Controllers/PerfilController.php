<?php

namespace siscontrat\Http\Controllers;

use Request;
use siscontrat\Http\Controllers\Controller;
use siscontrat\Models\admin\Perfil;

class PerfilController extends Controller
{
  public function criar()
  {
    return view("admin.perfil.criar");
  }

  public function salvar()
  {      
    return "salvar";
  }
}

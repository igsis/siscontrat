<?php

namespace siscontrat\Http\Controllers;

use Request;
use siscontrat\Http\Controllers\Controller;
use siscontrat\Models\admin\UsuarioContrato;
use siscontrat\Models\admin\Usuario;

class UsuarioContratoController extends Controller
{
  public function index()
  {     
    return view("admin.usuarioContrato.index")
      ->with("usuarios", Usuario::all());
  }
}

<?php

namespace siscontrat\Http\Controllers;

use Request;
use siscontrat\Http\Controllers\Controller;
use siscontrat\Models\admin\UsuarioContrato;
use siscontrat\Models\admin\Usuario;
use siscontrat\Http\Controllers\UsuarioController;

class UsuarioContratoController extends Controller
{
  private $numPag = 10;
  public $usuario = new UsuarioController();


  public function salvar()
  {
    UsuarioContrato::create(Request::all());

    return $this->usuario->index();
  }
}

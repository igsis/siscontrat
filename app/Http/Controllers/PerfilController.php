<?php

namespace siscontrat\Http\Controllers;

use Request;
use siscontrat\Http\Controllers\Controller;
use siscontrat\Models\admin\Perfil;

class PerfilController extends Controller
{
  public function index()
  {
    return view("admin.perfil.index")
      ->with("perfis", Perfil::all());
  }


  public function criar()
  {
    return view("admin.perfil.criar");
  }

  public function salvar()
  {      
    Perfil::create(Request::all());

    return view('admin.perfil.criar');
  }
}

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
      ->with("perfis", Perfil::orderBy('descricao', 'asc')->get());
  }

  public function criar()
  {
    return view("admin.perfil.form");      
  }

  public function salvar()
  {      
    Perfil::create(Request::all());

    return redirect()
      ->action('PerfilController@criar')
      ->withInput(Request::only('descricao'));
  }

  public function editar($id)
  {
     return view('admin.perfil.form')
       ->with('perfil', Perfil::find($id));
  }

  public function atualizar()
  {
    $perfil = Perfil::find(Request::input('id'));
    $perfil->descricao = Request::input('descricao');
    $perfil->save();

    return redirect()
      ->action('PerfilController@index')
      ->withInput(Request::only(['id', 'descricao']));
  }

}

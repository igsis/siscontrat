<?php

namespace siscontrat\Http\Controllers;

use Request;
use siscontrat\Http\Controllers\Controller;
use siscontrat\Models\admin\Perfil;
use siscontrat\Http\Requests\PerfilRequest;

class PerfilController extends Controller
{
  private $totalPagina = 10;  
  
  public function index()
  {
    return view("admin.perfil.index")
      ->with("perfis", Perfil::paginate($this->totalPagina));
  }

  public function form()
  {
    return view("admin.perfil.form");      
  }

  public function salvar(PerfilRequest $pr)
  {      
    Perfil::create($pr->all());

    return redirect()
      ->action('PerfilController@form')
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

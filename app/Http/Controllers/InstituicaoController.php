<?php

namespace siscontrat\Http\Controllers;

use Request;
use siscontrat\Http\Controllers\Controller;
use siscontrat\Models\admin\Instituicao;
use siscontrat\Http\Requests\InstituicaoRequest;

class InstituicaoController extends Controller
{
  private $totalPagina = 10;  

  public function index()
  {
    return view("admin.instituicao.index")
      ->with("instituicoes", Instituicao::paginate($this->totalPagina));
  }

   public function form()
   {
      return view("admin.instituicao.form");      
   }

   public function salvar(InstituicaoRequest $pr)
  {      
    Instituicao::create($pr->all());

    return redirect()
      ->action('InstituicaoController@form')
      ->withInput(Request::only('nome', 'sigla'));
  }

  public function editar($id)
  {
     return "oi";
     /*return view('admin.perfil.form')
       ->with('perfil', Perfil::find($id));*/
  }
}

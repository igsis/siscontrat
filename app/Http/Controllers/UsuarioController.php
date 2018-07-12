<?php

namespace siscontrat\Http\Controllers;

use Request;
use siscontrat\Http\Controllers\Controller;
use siscontrat\Models\admin\Usuario;
use siscontrat\Models\admin\Perfil;
use DB;


class UsuarioController extends Controller
{  
  public function index()
  {
    return view("admin.usuario.index");
  }

  public function criar()
  {
    return view("admin.usuario.form")
      ->with('perfils', Perfil::orderBy('descricao')->get()); 
  }    

  public function salvar()
  {      
    Usuario::create(Request::all());    
  }

  public function validaLogin($nome)
  {
    
    /*$usuario = DB::select('
      SELECT 
        usuario 
      FROM usuarios AS u
      WHERE u.usuario = ?', [$login]);    

    if(sizeof($usuario) > 0):
      return view("admin.usuario.form")
        ->with('perfils', Perfil::orderBy('descricao')->get()) 
        ->with('login', $login)
        ->withInput(Request::all());
    endif;  
    
    return redirect()
      ->action('UsuarioController@criar');*/

    $nome = Request::only('nome');
    

    return 
      view("admin.usuario.form")
      ->with('perfils', Perfil::orderBy('descricao')->get())       
      ->withInput(Request::only(['nome']));

  }

  
}

<?php

namespace siscontrat\Http\Controllers;

use Request;
use siscontrat\Http\Controllers\Controller;
use siscontrat\Models\admin\Usuario;
use siscontrat\Models\admin\Perfil;

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

  public function validaUsuario()
  {     
    $usuario = Request::input('usuario');

    $resultado = 
      Usuario::where('usuario', '=', $usuario)->get();  

    if(sizeof($resultado) > 0):
      return redirect()            
        ->action('UsuarioController@criar')           
        ->withInput(Request::all());        
    endif;    

    return redirect()            
        ->action('UsuarioController@criar')           
        ->withInput(Request::except('checkUser'));
  }  
}

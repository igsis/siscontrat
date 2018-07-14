<?php

namespace siscontrat\Http\Controllers;

use Request;
use siscontrat\Http\Controllers\Controller;
use siscontrat\Models\admin\Usuario;
use siscontrat\Models\admin\Perfil;
use siscontrat\Http\Requests\UsuarioRequest;

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

  public function salvar(UsuarioRequest $ur)
  {      
    Usuario::create($ur->all());    
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

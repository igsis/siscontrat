<?php

namespace siscontrat\Http\Controllers;

use Request;
use siscontrat\Http\Controllers\Controller;
use siscontrat\Models\admin\Usuario;
use siscontrat\Models\admin\Perfil;
use siscontrat\Http\Requests\UsuarioRequest;
use Hash;

class UsuarioController extends Controller
{  
  public function index()
  {
    return view("admin.usuario.index");
  }

  public function form()
  {    
    return view("admin.usuario.form")      
      ->with('perfils', Perfil::orderBy('descricao')->get()); 
  }

  public function salvar(UsuarioRequest $ur)
  {          
    
    Usuario::create($ur->all());           
    
    return view("admin.usuario.form")      
      ->with('perfils', Perfil::orderBy('descricao')->get())
      ->with('recordSuccess', true);   
  }  

  public function validaUsuario()
  {     
    $comparaUsuarios = 
      Usuario::where('usuario', '=', Request::input('usuario'))->get();      

    if(sizeof($comparaUsuarios) > 0):
      return redirect()            
        ->action('UsuarioController@form')           
        ->withInput(Request::all());        
    endif;        
    
    return redirect()            
        ->action('UsuarioController@form')           
        ->withInput(Request::except('verificaUsuario'));   
  }  

  public function validaEmail()
  {     
    $procuraEmail = 
      Usuario::where('email', '=', Request::input('email'))->get();  
    
    if(sizeof($procuraEmail) > 0):
      return redirect()            
        ->action('UsuarioController@form')           
        ->withInput(Request::all());        
    endif;        

    return redirect()            
        ->action('UsuarioController@form')           
        ->withInput(Request::except('verificaEmail'));
  }  
}

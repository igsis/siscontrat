<?php

namespace siscontrat\Http\Controllers;

use Request;
use siscontrat\Http\Controllers\Controller;
use siscontrat\Models\admin\Usuario;
use siscontrat\Models\admin\Perfil;
use siscontrat\Http\Requests\UsuarioRequest;
use DB;

class UsuarioController extends Controller
{  
  public function index()
  {   
    return view("admin.usuario.index")
      ->with("usuarios", Usuario::all());      
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
      ->with('msgInsert', true);   
  }  

  public function detalhe($id)
  {
    return view('admin.usuario.detalhes')
           -> with('usuario', Usuario::find($id));  
  }

  public function editar($id)
  {
     return view('admin.usuario.form_edit')
       ->with('usuario', Usuario::find($id))
       ->with('perfils', Perfil::orderBy('descricao')->get());
  }

  public function atualizar()
  {
    $campos = Request::only([
      'nome_completo',       
      'email',
      'telefone',
      'perfil_id',
      'id']);

    DB::update("
      UPDATE usuarios SET 
        nome_completo = ?,        
        email = ?,
        telefone = ?,
        perfil_id = ?
      WHERE id = ?", array_values($campos));     
     
     return redirect()        
        ->action('UsuarioController@index')
        ->withInput(Request::only(['id', 'nome_completo']));
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

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
    $usuarios = DB::table('usuarios')
      ->join('perfis', 'perfis.id', '=', 'usuarios.perfil_id')  
      ->select('usuarios.*','perfis.descricao as perfil_nome')
      ->get();

    return view("admin.usuario.index")
      ->with("usuarios", $usuarios);      
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

  public function detalhe($id)
  {
    $usuario = 
      DB::select("
        SELECT a.*, p.descricao as nome_perfil 
        FROM usuarios AS a
        INNER JOIN perfis AS p
        ON p.id = a.perfil_id
        WHERE a.id = ?", [$id]);

    return view('admin.usuario.detalhes')
           -> with('usuario', $usuario[0]);  
  }

  public function editar($id)
  {
     return view('admin.usuario.form')
       ->with('usuario', Usuario::find($id))
       ->with('perfils', Perfil::orderBy('descricao')->get());
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

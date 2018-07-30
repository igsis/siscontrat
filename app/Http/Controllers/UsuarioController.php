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
  private $numPag = 10;
  private $senhaDefault = "siscontrat2018";

  public function index($ordenar = 'usuario', $ultimoFiltro = '')
  { 
    return view("admin.usuario.index")
      ->with("usuarios", 
        Usuario::orderBy($ordenar, 'asc')->paginate($this->numPag))
      ->with('ultimoFiltro', $ultimoFiltro);      
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

  public function editar($id)
  {
     return view('admin.usuario.form_edit')
       ->with('usuario', Usuario::find($id))
       ->with('perfils', Perfil::orderBy('descricao')->get());
  }

  public function procuraEmail(Request $r)
  {    
    $validaEmail = $r::only(['email', 'usuario']);

    $achouEmail = DB::select("
                    SELECT email FROM usuarios AS a
                    WHERE a.email =  ?
                    AND a.usuario != ?", array_values($validaEmail)); 
    
    if(sizeof($achouEmail) > 0):
      return true;
    endif;  

    return false;
  }
  
  public function atualizar(Request $r)
  {    
    if($this->procuraEmail($r)):      
      return view('admin.usuario.form_edit')
        ->with('msgUpdate', true)        
        ->with('usuario', Usuario::find(implode($r::only('id'))))
        ->with('perfils', Perfil::orderBy('descricao')->get());        
    endif;  
    
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

  public function delete(Request $r)
  { 
    if(implode($r::only('publicado')) == "Sim"):
      DB::update("
        UPDATE usuarios SET 
          publicado = 0                
        WHERE usuario = ?", array_values($r::only('usuario')));     
    else:
      DB::update("
        UPDATE usuarios SET 
          publicado = 1                
        WHERE usuario = ?", array_values($r::only('usuario')));
    endif;  

    return redirect()
        ->action('UsuarioController@index');     
  }

  public function filtro()
  {    
    $filtro = implode(Request::only('filtro'));
    return $this->index($filtro, $filtro);
  }  
  
  public function resetSenha($id)
  {
    $usuario = Usuario::find($id);
    $usuario->senha = bcrypt($this->senhaDefault);
    $usuario->save();     

    return view("admin.usuario.index")
      ->with("usuarios", 
        Usuario::orderBy('usuario', 'asc')->paginate($this->numPag))
      ->with('ultimoFiltro', $ultimoFiltro = '')  
      ->with('resetSenha', true);
  }
}

<?php

namespace siscontrat\Http\Controllers;

use Request;
use siscontrat\Http\Controllers\Controller;
use siscontrat\Models\admin\UsuarioContrato;
use siscontrat\Models\admin\Usuario;
use DB;

class UsuarioContratoController extends Controller
{
  public function index()
  {     
    $usuarios = DB::select(
      "SELECT 
        u.id,
        u.nome_completo, 
        u.usuario, 
        u.email, 
        u.publicado, 
        uc.usuario_id, 
        uc.nivel_acesso as nivel_acesso

       FROM usuarios AS u
	   LEFT JOIN usuario_contratos AS uc
	   ON uc.usuario_id = u.id");

    return view("admin.usuarioContrato.index")
      ->with("usuarios", $usuarios);
  }

  public function procuraUsuario($usuario_id)
  {     
    $procuraUsuario = 
      UsuarioContrato::where('usuario_id', '=', $usuario_id)->get();
    
    return sizeof($procuraUsuario) > 0 ? true : false;      
  }
  
  public function salvar()
  { 
    $usuario_id = implode(Request::only('usuario_id'));    
    
    if($this->procuraUsuario($usuario_id)):
      DB::delete("
        DELETE FROM usuario_contratos            
        WHERE usuario_id = ?", array($usuario_id));     
    else:
      UsuarioContrato::create(Request::all());
    endif;	

    return redirect()
      ->action('UsuarioContratoController@index');    
  }    
}

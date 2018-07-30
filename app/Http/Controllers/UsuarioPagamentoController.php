<?php

namespace siscontrat\Http\Controllers;

use siscontrat\Http\Controllers\Controller;
use siscontrat\Models\admin\Usuario;
use siscontrat\Models\admin\UsuarioPagamento;
use Request;
use DB;

class UsuarioPagamentoController extends Controller
{
  public function procuraUsuario($usuario_id)
  {     
    $procuraUsuario = 
      UsuarioPagamento::where('usuario_id', '=', $usuario_id)->get();
    
    return sizeof($procuraUsuario) > 0 ? true : false;      
  }
  
  public function salvar()
  { 
    $usuario_id = implode(Request::only('usuario_id'));    
    
    if($this->procuraUsuario($usuario_id)):
      DB::delete("
        DELETE FROM usuario_pagamentos            
        WHERE usuario_id = ?", array($usuario_id));     
    else:
      UsuarioPagamento::create(Request::all());
    endif;	

    return redirect()
      ->action('UsuarioContratoController@index') 
      ->withInput(Request::only('usuario_id'));   
  }    
}

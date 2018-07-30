<?php

namespace siscontrat\Models\admin;

use Illuminate\Database\Eloquent\Model;

class UsuarioPagamento extends Model
{
  protected $table = "usuario_pagamentos";
  protected $fillable = [
  	  'usuario_id', 
  	  'nivel_acesso'   	  
   ];    
  public $timestamps = false;

  public function usuario()
  {
    return $this->belongsTo(Usuario::class);
  }       
}

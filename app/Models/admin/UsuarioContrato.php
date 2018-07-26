<?php

namespace siscontrat\Models\admin;

use Illuminate\Database\Eloquent\Model;

class UsuarioContrato extends Model
{
   protected $table = "usuario_contratos";
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

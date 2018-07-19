<?php

namespace siscontrat\Models\admin;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{   
  protected $table = "usuarios";
  
  protected $fillable = [
  	  'nome_completo', 
  	  'usuario', 
  	  'senha', 
  	  'email', 
  	  'telefone', 
      'perfil_id'
  ];
  
  protected $guarded = '[id]';
  
  public $timestamps = false;

  public function setSenhaAttribute($senha) {
    $this->attributes['senha'] = bcrypt($senha);
  }

  public function perfil()
  {
    return $this->belongsTo(Perfil::class);
  }
  

}

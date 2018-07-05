<?php

namespace siscontrat\Models\admin;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
  protected $table = "usuarios";
   
  protected $fillable = ['nome_completo', 'usuario', 'senha', 'email', 'telefone'];

  protected $guarded = '[id]';  
  public $timestamps = false;     

  
}

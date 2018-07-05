<?php

namespace siscontrat\Models\admin;

use Illuminate\Database\Eloquent\Model;

class perfil extends Model
{
  protected $table = "perfis";  
  protected $fillable = ['descricao'];
  protected $guarded = '[id]';  
  public $timestamps = false;     
  

}

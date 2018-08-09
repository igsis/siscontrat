<?php

namespace siscontrat\Models\admin;

use Illuminate\Database\Eloquent\Model;

class Instituicao extends Model
{
  protected $table = "instituicoes";  
  protected $fillable = ['nome', 'sigla'];
  protected $guarded = '[id]';  
  public $timestamps = false;       
}

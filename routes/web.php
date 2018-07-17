<?php
Route::get('/', function () {
    return view('layout.menu.principal');
});

Route::group(['as' => 'menu.', 'prefix' => 'menu'], function(){	    
  Route::get('/menu/admin',   ['as' => 'admin',  'uses' => 'MenuController@admin']); 
});

Route::group(['as' => 'perfil.', 'prefix' => 'perfil'], function(){	  
  Route::get('/lista',       ['as' => 'index',  'uses' => 'PerfilController@index']);
  
  Route::get('/novo',        ['as' => 'form',  'uses' => 'PerfilController@form']);
  
  Route::post('/salvar',     ['as' => 'salvar', 'uses' => 'PerfilController@salvar']);
  
  Route::get('/editar/{id}', ['as' => 'editar', 'uses' => 'PerfilController@editar']);
  
  Route::post('/atualizar',   ['as' => 'atualizar', 'uses' => 'PerfilController@atualizar']);
});

Route::group(['as' => 'usuario.', 'prefix' => 'usuario'], function(){	  
  Route::get('/lista',   ['as' => 'index',  'uses' => 'UsuarioController@index']);
  
  Route::get('/novo',    ['as' => 'form',  'uses' => 'UsuarioController@form']);  
  
  Route::post('/salvar', ['as' => 'salvar', 'uses' => 'UsuarioController@salvar']);    
  
  Route::post('novo/validar',
    ['as' => 'validar', 'uses' => 'UsuarioController@validaUsuario']);   
  
  Route::post('novo/validarEmail', ['as' => 'validarEmail', 'uses' =>   
    'UsuarioController@validaEmail']);

});





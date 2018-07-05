<?php
Route::get('/', function () {
    return view('welcome');
});

Route::group(['as' => 'perfil.', 'prefix' => 'perfil'], function(){	  
  Route::get('/lista',  ['as' => 'index',  'uses' => 'PerfilController@index']);
  Route::get('/novo',  ['as' => 'criar',  'uses' => 'PerfilController@criar']);
  Route::post('/salvar', ['as' => 'salvar', 'uses' => 'PerfilController@salvar']);
});


Route::group(['as' => 'usuario.', 'prefix' => 'usuario'], function(){	  
  Route::get('/lista',  ['as' => 'index',  'uses' => 'UsuarioController@index']);
  Route::get('/novo',  ['as' => 'criar',  'uses' => 'UsuarioController@criar']);  
  Route::post('/salvar', ['as' => 'salvar', 'uses' => 'UsuarioController@salvar']);

});






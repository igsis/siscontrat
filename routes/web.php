<?php
Route::get('/', function () {
    return view('welcome');
});

Route::group(['as' => 'usuario.', 'prefix' => 'usuario'], function(){	
  
  Route::get('/criar',  ['as' => 'criar',  'uses' => 'UsuarioController@criar']);
  
  Route::post('/salvar', ['as' => 'salvar', 'uses' => 'UsuarioController@salvar']);

});

/*Route::get('/usuario/criar', 'UsuarioController@criar');
Route::post('/usuario/salvar', 'UsuarioController@salvar');*/





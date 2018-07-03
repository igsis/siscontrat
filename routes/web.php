<?php
Route::get('/', function () {
    return view('welcome');
});


Route::group(['as' => 'usuario.', 'prefix' => 'usuario'], function(){	
  Route::get('/novo', ['as' => 'criar', 'uses' => 'UsuarioController@criar']);	
});

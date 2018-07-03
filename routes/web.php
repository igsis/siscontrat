<?php
Route::get('/', function () {
    return view('welcome');
});


Route::group(['as' => 'adm.', 'prefix' => 'usuario'], function(){	
  Route::get('/novo', ['as' => 'criar', 'uses' => 'UsuarioController@criar']);	
});

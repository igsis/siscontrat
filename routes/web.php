<?php
Route::get('/', function () {
    return view('welcome');
});

/**USUÁRIO**/
Route::group(['prefix' => 'usuario'], function(){
	
	Route::get('/cadastro', 'UsuarioController@form');	

});

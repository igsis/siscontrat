<?php 
Route::group(['as' => 'perfil.', 'prefix' => 'perfil'], 
	function(){	  
		Route::get('/lista',       ['as' => 'index',  'uses' => 'PerfilController@index']);

		Route::get('/novo',        ['as' => 'form',  'uses' => 'PerfilController@form']);

		Route::post('/salvar',     ['as' => 'salvar', 'uses' => 'PerfilController@salvar']);

		Route::get('/editar/{id}', ['as' => 'editar', 'uses' => 'PerfilController@editar'])->where('id', '[0-9]+');

		Route::post('/atualizar',   ['as' => 'atualizar', 'uses' => 'PerfilController@atualizar']);
	});
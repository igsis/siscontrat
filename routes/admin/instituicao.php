<?php 
Route::group(['as' => 'instituicao.', 'prefix' => 'instituicao'], 
  function(){   
    Route::get('/lista',       ['as' => 'index',  'uses' => 
      'InstituicaoController@index']);
    
    Route::get('/novo',        ['as' => 'form',  'uses' => 
      'InstituicaoController@form']);
    
    Route::post('/salvar',     ['as' => 'salvar', 'uses' => 
      'InstituicaoController@salvar']);
    
    Route::get('/editar/{id}', ['as' => 'editar', 'uses' => 
      'InstituicaoController@editar'])->where('id', '[0-9]+');
    
    Route::post('/atualizar',   ['as' => 'atualizar', 'uses' => 
      'InstituicaoController@atualizar']);
  });
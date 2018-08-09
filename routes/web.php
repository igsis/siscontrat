<?php
Route::get('/', function () {
    return view('layout.menu.principal');
});

/**MENU**/
Route::group(['as' => 'menu.', 'prefix' => 'menu'], function(){	    
  Route::get('/menu/admin',   ['as' => 'admin',  'uses' => 'MenuController@admin']); 
});

/**PERFIL**/
Route::group(['as' => 'perfil.', 'prefix' => 'perfil'], function(){	  
  Route::get('/lista',       ['as' => 'index',  'uses' => 'PerfilController@index']);
  
  Route::get('/novo',        ['as' => 'form',  'uses' => 'PerfilController@form']);
  
  Route::post('/salvar',     ['as' => 'salvar', 'uses' => 'PerfilController@salvar']);
  
  Route::get('/editar/{id}', ['as' => 'editar', 'uses' => 'PerfilController@editar'])->where('id', '[0-9]+');
  
  Route::post('/atualizar',   ['as' => 'atualizar', 'uses' => 'PerfilController@atualizar']);
});

/**USUARIO**/
Route::group(['as' => 'usuario.', 'prefix' => 'usuario'], function(){	  
  
  Route::get('/lista',   
    ['as' => 'index',  'uses' => 'UsuarioController@index']);
  
  Route::get('/novo',  ['as' => 'form',  'uses' => 'UsuarioController@form']);    
  Route::post('/salvar', 
    ['as' => 'salvar', 'uses' => 'UsuarioController@salvar']);    
  
  Route::post('novo/validar',
    ['as' => 'validar', 'uses' => 'UsuarioController@validaUsuario']);   
  
  Route::post('novo/validarEmail', ['as' => 'validarEmail', 'uses' =>   
    'UsuarioController@validaEmail']);
  
  Route::get('/editar/{id}', ['as' => 'editar', 'uses' => 
    'UsuarioController@editar'])->where('id', '[0-9]+');

  Route::post('/atualizar', ['as' => 'atualizar', 
    'uses' => 'UsuarioController@atualizar']);

  Route::post('/delete', ['as' => 'delete', 
    'uses' => 'UsuarioController@delete']);  

  Route::post('/filtro', ['as' => 'filtro',  'uses' => 
      'UsuarioController@filtro']);  

  Route::get('/resetSenha/{id}', ['as' => 'editar', 'uses' => 
    'UsuarioController@resetSenha'])->where('id', '[0-9]+');
});


/**USUARIO-CONTRATO**/
Route::group(['as' => 'usuarioCnt.', 'prefix' => 'usuarioCnt'], 
  function(){   
  
    Route::get('/lista', ['as' => 'index',  'uses' => 
      'UsuarioContratoController@index']);   

    Route::post('/salvar', ['as' => 'salvar',  'uses' => 
      'UsuarioContratoController@salvar']);   
  }
);

/**USUARIO-PAGAMENTO**/
Route::group(['as' => 'usuarioPgto.', 'prefix' => 'usuarioPgto'], 
  function(){   

    Route::post('/salvar', ['as' => 'salvar',  'uses' => 
      'UsuarioPagamentoController@salvar']);   
  }
);

/**INSTITUICAO**/
Route::group(['as' => 'instituicao.', 'prefix' => 'instituicao'], 
  function(){   
    /*Route::get('/lista',       ['as' => 'index',  'uses' => 'PerfilController@index']);*/
  
    Route::get('/novo',        ['as' => 'form',  'uses' => 
      'InstituicaoController@form']);
  
  Route::post('/salvar',     ['as' => 'salvar', 'uses' => 
    'InstituicaoController@salvar']);
  
  /*Route::get('/editar/{id}', ['as' => 'editar', 'uses' => 'PerfilController@editar'])->where('id', '[0-9]+');
  
  Route::post('/atualizar',   ['as' => 'atualizar', 'uses' => 'PerfilController@atualizar']);*/
});


/*
  Template adminLTE
*/
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
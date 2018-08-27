<?php

Route::get('/', function () {
  return view('layout.menu.principal');
});

/**MENU**/
Route::group(['as' => 'menu.', 'prefix' => 'menu'], function(){	    
  Route::get('/menu/admin',   ['as' => 'admin',  'uses' => 'MenuController@admin']); 
});

/*
  Template adminLTE
*/
  Auth::routes();

  Route::get('/home', 'HomeController@index')->name('home');
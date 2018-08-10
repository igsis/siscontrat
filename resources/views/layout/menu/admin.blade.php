@extends('layout.header')

@section('titulo')
  Menu Administrator
@stop()

@section('menu')
  <nav class="navbar navbar-default setMenuAdmin">
    <div class="container-fluid">                
      <div class="navbar-header">      
        <a class="navbar-brand" href="/">Menu</a>
      </div>          
      <ul class="nav navbar-nav">
        <li class="dropdown dropdown-submenu"><a href="#" 
            class="dropdown-toggle" 
            data-toggle="dropdown">Cadastro</a>
            <ul class="dropdown-menu">
              <li>
                <a href="{{action('PerfilController@form')}}">Perfil</a>
              </li>
              <li>
                <a href="{{action('UsuarioController@form')}}">Usuário</a>
              </li>               
              <li>
                <a href="{{action('InstituicaoController@form')}}">Instituição</a>
              </li>               
            </ul>
        </li>             
      </ul>
      <ul class="nav navbar-nav">
        <li class="dropdown dropdown-submenu"><a href="#" 
            class="dropdown-toggle" 
            data-toggle="dropdown">Parâmetros</a>
            <ul class="dropdown-menu">              
              <li>
                <a href="{{action('UsuarioContratoController@index')}}">Usuário</a>
              </li>              
            </ul>
        </li>             
      </ul>
      <ul class="nav navbar-nav">
        <li class="dropdown dropdown-submenu"><a href="#" 
            class="dropdown-toggle" 
            data-toggle="dropdown">Lista</a>
            <ul class="dropdown-menu">
              <li><a href="{{action('PerfilController@index')}}">Perfil</a></li>
              <li><a href="{{action('UsuarioController@index')}}">Usuário</a></li>                            
              <li><a href="{{action('InstituicaoController@index')}}">Instituição</a></li>
            </ul>
        </li>             
      </ul>          
    </div>
  </nav>
  @yield('conteudo')	
@stop()
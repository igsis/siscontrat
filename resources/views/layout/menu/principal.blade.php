@extends('layout.header')

@section('titulo')
  Menu Principal
@stop()

@section('menu')
  <nav class="navbar navbar-default setMenuAdmin">
    <div class="container-fluid">                
      <div class="navbar-header">      
        <a class="navbar-brand" href="/">Menu</a>
      </div>          
      <ul class="nav navbar-nav">
        <li><a href="{!! route('menu.admin') !!}">Administrador</a></li>
      </ul>          
    </div>
  </nav>      
@stop()

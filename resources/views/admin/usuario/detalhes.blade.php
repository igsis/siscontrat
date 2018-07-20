@extends('layout.menu.admin')

@section('titulo')
  Detalhes do usuário
@stop()  

@section('conteudo')        
  <h1>Detalhes do Usuário: <b>{{$usuario->usuario}}</b>
  <ul>
    <hr>
      <li>ID: {{$usuario->id}}</li>	    
      <li>Nome Completo: {{$usuario->nome_completo}}</li>	
      <li>Email: {{$usuario->email}}</li>	
      <li>Telefone: {{$usuario->telefone}}</li>
      <li>Perfil: {{$usuario->perfil->descricao}}</li>
      <li>Data Cadastro: {{$usuario->data_cadastro}}</li>
      <li>Últimpo Acesso: {{$usuario->ultimo_acesso}}</li>
      <li>Publicado: {{$usuario->publicado == 1 ? "Sim" : "Não"}}</li>
    <hr>
  </ul>	
@stop()
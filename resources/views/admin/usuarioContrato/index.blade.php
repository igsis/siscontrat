@extends('layout.menu.admin')

@section('titulo')
  Relação de usuarios
@stop()  

@section('conteudo') 
  <table align="center" class="table table-stripped table-hover" 
  		 id="tb_usuarios">
    <thead>
      <tr>    
        <th>Nome Completo</th>      
        <th>Usuário</th>
        <th>Email</th>        
        <th>Publicado</th>
        <th>Contrato</th>
        <th>Financeiro</th>        
      </tr> 
    </thead>  
    <tbody>
      @foreach($usuarios as $u)
        <tr scope="row" class="{{$u->publicado == 0 ? 'alert-danger' :''}} usuarios">
          <td>{{$u->nome_completo}}</td>
          <td>{{$u->usuario}}</td>
          <td>{{$u->email}}</td>          
          <td>{{$u->publicado == 1 ? "Sim" : "Não"}}</td>
        </tr> 
      @endforeach        
    </tbody>
  </table>   
@stop()
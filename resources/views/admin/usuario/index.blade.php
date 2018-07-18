@extends('layout.menu.admin')

@section('titulo')
  Relação de usuarios
@stop()  

@section('conteudo')  
  <a href="{!! route('usuario.form') !!}" class="btn btn-primary">+Novo</a>
  <table align="center" 
         class="table table-stripped table-hover">
    <thead>
      <tr>    
        <th>Nome Completo</th>      
        <th>Usuário</th>
        <th>Email</th>        
        <th>Perfil</th>                
        <th>Publicado</th>
      </tr>	
    </thead>	
    <tbody>
      @foreach($usuarios as $u)
        <tr scope="row" class="{{$u->publicado == 0 ? 'alert-danger' : ''}}">
          <td>{{$u->nome_completo}}</td>                
          <td>{{$u->usuario}}</td>
          <td>{{$u->email}}</td>          
          <td>{{$u->perfil_nome}}</td>                    
          <td>{{$u->publicado == 1 ? "Sim" : "Não"}}</td>  
          <td>
            <a href="/usuario/detalhe/{{$u->id}}">Detalhes</a>
          </td>                
          <td>
            <a href="/usuario/editar/{{$u->id}}">Alterar</a>
          </td>                
          <td>
            <a href="/usuario/delete/{{$u->id}}">
              {{$u->publicado == 1 ? "Despublicar" : "Publicar"}}
            </a>
          </td>                
        </tr>	
      @endforeach        
    </tbody>
  </table>    
@stop      
  

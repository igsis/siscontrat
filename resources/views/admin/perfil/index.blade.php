@extends('layout.menu.admin')

@section('titulo')
  Relação de perfis
@stop()

@section('conteudo')
<table align="center" class=" table tabela-perfil table-dark" >
  <thead>
    <tr>
      <th scope="col">Descrição</th>  	      
    </tr>	
  </thead>	
  <tbody>
    @foreach($perfis as $perfil)
      <tr scope="row">      
        <td>{{$perfil->descricao}}</td>        
        <td>
          <a href="#">Alterar</a>
        </td>
        <td>
          <a href="#">Desabilitar</a>
        </td>            
      </tr>	
    @endforeach        
  </tbody>
</table>  
</div>
@stop
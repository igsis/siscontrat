@extends('layout.menu.admin')

@section('titulo')
  Relação de perfis
@stop()

@section('conteudo')
@include('admin.perfil.mensagens', ['msg' => old('id')])
<table align="center" class=" table table-stripped table-hover tabela-perfil " >
  <thead>
    <tr>      
    </tr>	
  </thead>	
  <tbody>
    @foreach($perfis as $perfil)
      <tr scope="row">      
        <td>{{$perfil->descricao}}</td>                
        <td>
          <a href="/perfil/editar/{{$perfil->id}}">Alterar</a>
        </td>                
      </tr>	
    @endforeach        
  </tbody>
</table>  
</div>
@stop
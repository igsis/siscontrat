@extends('layout.menu.admin')

@section('titulo')
  Relação de instituições
@stop()

@section('conteudo')
@include('admin.instituicao.mensagens', ['msg' => old('id')])
<a href="{!!route('instituicao.form')!!}" class="btn btn-primary">+Novo</a>
<table align="center" class=" table table-stripped table-hover tabela-perfil">
  <thead>
    <tr>    
      <th>Nome</th>      
      <th>Sigla</th>
    </tr>	
  </thead>	
  <tbody>
    @foreach($instituicoes as $i)
      <tr scope="row">      
        <td>{{$i->nome}}</td>                
        <td>{{$i->sigla}}</td>
        <td>
          <a href="/instituicao/editar/{{$i->id}}">Alterar</a>
        </td>                
      </tr>	
    @endforeach        
  </tbody>
</table>  
<div class="paginacao">
  {!!$instituicoes->links()!!}  
</div>  
@stop


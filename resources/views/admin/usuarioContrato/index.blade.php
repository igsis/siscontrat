@extends('layout.menu.admin')

@section('titulo')
  Relação de usuarios
@stop()  

<!--Uso js-->
<form action="#" method="post" id="frm_index_usuario"> 
  {{csrf_field()}}      
</form>

@section('conteudo') 
  @include('admin.usuarioContrato.mensagens')
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
          <td class="ocultar" id="id">{{$u->id}}</td>          
          <td class="ocultar" id="nivel">{{$u->nivel_acesso}}</td>
          <td>{{$u->nome_completo}}</td>
          <td>{{$u->usuario}}</td>
          <td>{{$u->email}}</td>          
          <td>{{$u->publicado == 1 ? "Sim" : "Não"}}</td>          
          <td>          
            <input type="checkbox" name="contrato" id="contrato" 
            {{$u->nivel_acesso == 1 ? 'checked="checked"' :''}}>
          </td>          
          <td>
            <input type="checkbox" name="financeiro" id="financeiro">
          </td>            
        </tr> 
      @endforeach        
    </tbody>
  </table>     
  <script type="text/javascript" 
          src="{{asset('/js/cadastro/admin/usuarioCnt.js')}}">
  </script>     
@stop()

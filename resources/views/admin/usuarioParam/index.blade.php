@extends('layout.menu.admin')

@section('titulo')
  Relação de usuarios
@stop()  

<!--Uso js-->
<form action="#" method="post" id="frm_index_usuario"> 
  {{csrf_field()}}      
</form>

@section('conteudo') 
  @include('admin.usuarioParam.mensagens')
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
          <td class="ocultar" id="nivel_c">{{$u->nivel_c}}</td>
          <td class="ocultar" id="nivel_p">{{$u->nivel_p}}</td>
          <td>{{$u->nome_completo}}</td>
          <td>{{$u->usuario}}</td>
          <td>{{$u->email}}</td>          
          <td>{{$u->publicado == 1 ? "Sim" : "Não"}}</td>          
          <td>          
            <input type="checkbox" name="contrato" id="contrato" 
            {{$u->nivel_c == 1 ? 'checked="checked"' :''}}>
          </td>          
          <td>          
            <input type="checkbox" name="pagamento" id="pagamento" 
            {{$u->nivel_p == 1 ? 'checked="checked"' :''}}>
          </td>          
        </tr> 
      @endforeach        
    </tbody>
  </table>     
  <script type="text/javascript" 
          src="{{asset('/js/cadastro/admin/usuarioCnt.js')}}">
  </script>     
  <script type="text/javascript" 
          src="{{asset('/js/cadastro/admin/usuarioPgto.js')}}">
  </script>     
@stop()

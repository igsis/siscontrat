@extends('layout.menu.admin')

@section('titulo')
  Relação de usuarios
@stop()  

<!--Uso js-->
<form action="#" method="post" id="frm_index_usuario"> 
  {{csrf_field()}}      
</form>

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
  <script type="text/javascript">        
     getUsuarios().forEach(function(usuario){
      var usuarioCont = usuario.querySelector('#contrato');
      
      usuarioCont.addEventListener('click', function(event){        
        gravaUsuarioContratos(usuario);  
      });
    });  

    function gravaUsuarioContratos(usuario)
    {
      var form = document.getElementById('frm_index_usuario');
          form.action = "/usuariocontrato/salvar";

      var inputUsuario = document.createElement('input');
          inputUsuario.setAttribute('type', 'hidden');
          inputUsuario.setAttribute('name', 'usuario_id');
          inputUsuario.setAttribute('value', setUsuario(usuario));    

      var inputAcesso = document.createElement('input');
          inputAcesso.setAttribute('type', 'hidden');
          inputAcesso.setAttribute('name', 'nivel_acesso');
          inputAcesso.setAttribute('value', setNivelAcesso(usuario));        

          form.appendChild(inputUsuario);      
          form.appendChild(inputAcesso);                                  
          //console.log(form);
          form.submit();
    } 
    
    function setNivelAcesso(usuario)
    {
      var nivel_acesso = usuario.querySelector('#nivel').textContent;
      return nivel_acesso == 1 ? 0 : 1;         
    }

    function setUsuario(usuario)
    {
      var user = usuario.querySelector('#id').textContent;          
      return user;
    }

    function getUsuarios()
    {
      var usuarios = document.querySelectorAll('.usuarios');
      return usuarios;
    }
  </script> 
@stop()

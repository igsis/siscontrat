@extends('layout.menu.admin')

@section('titulo')
  Relação de usuarios
@stop()  

@section('conteudo')  
  <div class="sub-menu-usuario">
    <div class="btnNovo">
      <a href="{!!route('usuario.form')!!}" class="btn btn-primary">
        +Novo
      </a>
    </div>
    <label>Nome completo</label>
    <div>      
      <input type="text" name="nomeUsuario" 
             class="form-control" 
             id="nomeUsuario">  
    </div>         
  </div>
  @include('admin.usuario.mensagens')
  
  <!--Uso js-->
  <form action="/usuario/delete" method="post" 
          id="frm_usuario_delete"> 
    {{csrf_field()}}  
    <input type="hidden" name="usuario" id="user"> 
    <input type="hidden" name="publicado" id="user_pub">
  </form>
  <table align="center" 
         class="table table-stripped table-hover" id="tb_usuarios">
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
        <tr scope="row" 
            class="{{$u->publicado == 0 ? 'alert-danger' : ''}} usuarios">
          <td>
            <a href="/usuario/editar/{{$u->id}}" class="info-nome">{{$u->nome_completo}}</a></td>                
          <td id="usuario">{{$u->usuario}}</td>
          <td>{{$u->email}}</td>          
          <td>{{$u->perfil->descricao}}</td>                    
          <td id="publicado">{{$u->publicado == 1 ? "Sim" : "Não"}}</td>  
          <td>
            <a href="/usuario/detalhe/{{$u->id}}">
              <span class="glyphicon glyphicon-search" aria-hidden="true">
              </span>
            </a>           
          </td>    
        </tr> 
      @endforeach        
    </tbody>
  </table>      
  <div class="paginacao">
    {!! $usuarios->links() !!}  
  </div>  
  <script type="text/javascript" 
          src="{{asset('js/validacoes/admin/usuarioPublica.js')}}">
  </script>      
  <script type="text/javascript" 
          src="{{asset('js/validacoes/admin/usuarioBusca.js')}}">
  </script>      
  
@stop       

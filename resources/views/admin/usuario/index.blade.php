@extends('layout.menu.admin')

@section('titulo')
  Relação de usuarios
@stop()  

@section('conteudo')  
  <div class="sub-menu-usuario">    
    
    <!--Novo Registro-->
    <div class="btnNovo">
      <a href="{!!route('usuario.form')!!}" class="btn btn-primary">
        +Novo
      </a>
    </div>    
    
    <!--Filtro-->
    <div class="selectFiltro">      
      <label for="filtro">Filtro</label>      
      <select class="form-control" id="filtro" onchange="pegaFiltro()">
        <option></option>        
        <option value="nome_completo" {{$ultimoFiltro == 'nome_completo' ? 'selected' : ''}}>Nome</option>                
        <option value="usuario" {{$ultimoFiltro == 'usuario' ? 'selected' : ''}}>Usuário</option>        
        <option value="email" {{$ultimoFiltro == 'email' ? 'selected' : ''}}>Email</option>        
        <option value="perfil_id" {{$ultimoFiltro == 'perfil_id' ? 'selected' : ''}}>Perfil</option>
      </select>  
    </div>      

    <!--Busca por nome-->
    <div class="inpNome">      
      <label for="nomeUsuario">Nome completo</label>    
      <input type="text" name="nomeUsuario" 
             class="form-control" 
             id="nomeUsuario">  
    </div>   
  </div>
  @include('admin.usuario.mensagens')
  
  <!--Uso js-->
  <form action="#" method="post" 
          id="frm_index_usuario"> 
    {{csrf_field()}}      
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
        <th>Contratos</th>
        <th>Financeiro</th>
      </tr> 
    </thead>  
    <tbody>
      @foreach($usuarios as $u)
        <tr scope="row" class="{{$u->publicado == 0 ? 'alert-danger' :''}} usuarios">
          <td>
            <a href="/usuario/editar/{{$u->id}}" class="info-nome">{{$u->nome_completo}}</a></td>                

          <td id="usuario"><a href="#" data-toggle="modal" class="info-usuario" data-target="#detalhes">{{$u->usuario}}</a>
          </td>
          <td>{{$u->email}}</td>          
          <td>{{$u->perfil->descricao}}</td>                    
          <td id="publicado">{{$u->publicado == 1 ? "Sim" : "Não"}}</td>
          <td class="ocultar" id="id">{{$u->id}}</td>          
          <td class="ocultar" id="nome_completo">{{$u->nome_completo}}
          </td>
          <td class="ocultar" id="telefone">{{$u->telefone}}</td>
          <td class="ocultar" id="perfil">{{$u->perfil->descricao}}</td>
          <td class="ocultar" id="dt_cadastro">{{$u->data_cadastro}}</td>
          <td class="ocultar" id="dt_acesso">{{$u->ultimo_acesso}}</td>
          <td>
            <input type="checkbox" name="usuarioContrato" 
                   id="usuarioContrato">
          </td>
          <td>
            <input type="checkbox" name="usuarioFinanceiro" 
                   id="usuarioFinanceiro">
          </td>
        </tr> 
      @endforeach        
    </tbody>
  </table>  
  
  @include('admin.usuario.detalhes')

  <div class="paginacao">
    {!! $usuarios->links() !!}  
  </div>    
  
  <script type="text/javascript" 
          src="{{asset('js/validacoes/admin/usuarioPublica.js')}}">
  </script>      
  <script type="text/javascript" 
          src="{{asset('js/validacoes/admin/usuarioBusca.js')}}">
  </script>     
  <script type="text/javascript" 
          src="{{asset('js/validacoes/admin/usuarioFiltro.js')}}">
  </script>   
  <script type="text/javascript" 
          src="{{asset('js/validacoes/admin/usuarioDetalhes.js')}}">
  </script>  
  <script type="text/javascript">
    getUsuarios().forEach(function(usuario){
      var usuarioCont = usuario.querySelector('#usuarioContrato');
      
      usuarioCont.addEventListener('click', function(event){        
        gravaUsuarioContratos(usuario);  
      });
    });

    function gravaUsuarioContratos(usuario)
    {
      var form = document.getElementById('frm_index_usuario');
          form.action = "/usuario/contrato";

      var inputUsuario = document.createElement('input');
          inputUsuario.setAttribute('type', 'hidden');
          inputUsuario.setAttribute('name', 'usuario_id');
          inputUsuario.setAttribute('value', getUsuario(usuario));    

      var inputAcesso = document.createElement('input');
          inputAcesso.setAttribute('type', 'hidden');
          inputAcesso.setAttribute('name', 'nivel_acesso');
          inputAcesso.setAttribute('value', '1');        

          form.appendChild(inputUsuario);      
          form.appendChild(inputAcesso);                        
          //console.log(form);
          form.submit();
    }
    
    function getUsuario(usuario)
    {
      var user = usuario.querySelector('#id').textContent;          
      return user;
    }
  
  </script> 
@stop     
<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script> 


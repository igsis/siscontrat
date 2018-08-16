@extends('adminlte::page')

@section('title', 'Edição de usuário')

@section('content_header')
    <h1>Editar Usuário</h1>
@stop

@section('content')     
  @include('admin.usuario.mensagens')
  @include('../validacoes/msgErro')
  <form action="{!!route('usuario.atualizar')!!}" id="#form" method="POST" 
        id="alteracaoUsuario">  	
    {{csrf_field()}}
    
    <!--Não apagar uso do js-->
    <div>
      <ul id="msg"></ul>
    </div>

    <input type="hidden" name="id" value="{{$usuario->id}}">
    <input type="hidden" name="usuario" value="{{$usuario->usuario}}">
    
    <div class="form-group">
  	  <label for="nome_completo">Nome Completo</label>	
  	  <input type="text" name="nome_completo" class="form-control"
             id="nome_completo" 
             required minlength="3" maxlength="70"               
             placeholder="Informe o nome completo do usuário"
             value="{{isset($usuario) ? $usuario->nome_completo 
                                     : old('nome_completo')}}">
  	</div>

    <div class="form-group">
      <label for="email">Email</label>  
      <input type="email" name="email" class="form-control" 
             id="email" 
             minlength="16" maxlength="60" required 
             onblur="validaEmail()"   
             pattern="[\w._%+-]+@[a-z0-9.]+\.[a-z]{1,3}$" 
             placeholder="Informe um email do usuário"              
             value="{{isset($usuario) ? $usuario->email 
                                     : old('email')}}">
    </div>      	

  	<div class="form-group">
  	  <label for="telefone">Telefone</label>	
  	  <input type="tel" name="telefone" class="form-control" 
             id="telefone"  
             minlength="14" maxlength="15" required 
             placeholder="(99)99999-9999"          
             pattern="\([0-9]{2}\)[\s][0-9]{4,5}-[0-9]{4}"      
             onkeyup="setMascara( this, getMascara );"
             value="{{isset($usuario) ? $usuario->telefone 
                                      : old('telefone')}}">
  	</div>

    <div class="form-group">
      <label for="">Perfil</label>
      <select name="perfil_id" class="form-control">            
        @foreach($perfils as $perfil)                  
          @if(isset($usuario))
            {{$selected = 
              $perfil->id == $usuario->perfil_id 
                ?'selected="selected"' :''}}                   
          @else
            {{$selected = 
              $perfil->id == old('perfil_id') 
              ? 'selected="selected"' : ''}}        
          @endif    
          <option value="{{$perfil->id}}" {{$selected}}?>  
            {{$perfil->descricao}}            
          </option>  
        @endforeach      
      </select>
    </div>         

  	<button type="submit" class="btn btn-success" id="btnSalvar">  
      Atualizar
    </button>
  </form>    
  <script type="text/javascript" 
          src="{{asset('/js/validacoes/admin/usuarioCampos.js')}}">
  </script>     
  
  <script type="text/javascript" 
          src="{{asset('/js/mascaras/telefone.js')}}">
  </script>  
@stop()
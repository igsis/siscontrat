@extends('layout.menu.admin')

@section('titulo')
  Cadastro de usuário
@stop()  

@section('conteudo')        
  @include('admin.usuario.mensagens')
  @include('../validacoes/msgErro')
  <form action="{!!route('usuario.salvar')!!}" method="POST" 
        id="cadastroUsuario">  	
    {{csrf_field()}}
    
    <!--Não apagar uso do js-->
    <div>
      <ul id="msg"></ul>
    </div>
    
    <div class="form-group">
  	  <label for="nome_completo">Nome Completo</label>	
  	  <input type="text" name="nome_completo" class="form-control" 
             minlength="3" maxlength="70" id="nome_completo" 
             required value="{{old('nome_completo')}}"                
             placeholder="Informe o nome completo do usuário">
  	</div>
  	
    <div class="form-group">
  	  <label for="usuario">Usuário</label>	
  	  <input type="text" name="usuario" class="form-control" 
             minlength="7" maxlength="7" id="usuario" required    
  	         onblur="validaUsuario()" value="{{old('usuario')}}"
             placeholder="Informe o login de acesso para o usuário">
             
  	</div>

  	<div class="form-group">
  	  <label for="senha">Senha</label>	
  	  <input type="password" name="senha" class="form-control"       
             minlength="6" maxlength="8" id="senha" required   
  	         placeholder="Informe uma senha para o usuário">
  	</div>

  	<div class="form-group">
  	  <label for="senha2">Confirme a Senha</label>	
  	  <input type="password" name="senhaConf" class="form-control"  
             minlength="6" maxlength="8" id="senhaConf" required 
             onblur="compararSenhas()" 
             placeholder="Confirme a senha para o usuário">
  	</div>
    
  	<div class="form-group">
  	  <label for="email">Email</label>	
  	  <input type="email" name="email" class="form-control" 
             minlength="13" maxlength="60"    
  	         placeholder="Informe um email do usuário" id="email" 
             pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" required
             value="{{old('email')}}">  	         
  	         
  	</div>    

  	<div class="form-group">
  	  <label for="telefone">Telefone</label>	
  	  <input type="tel" name="telefone" class="form-control" 
             id="telefone"  placeholder="(99)99999-9999"   	         
             maxlength="15" required
             pattern="\([0-9]{2}\)[\s][0-9]{4,5}-[0-9]{4}"  
             onkeyup="setMascara( this, getMascara );"
             value="{{old('telefone')}}">
  	</div>

    <div class="form-group">
      <label for="">Perfil</label>
      <select name="perfil_id" class="form-control">            
        @foreach($perfils as $perfil)                  
          {{$selected = $perfil->id == old('perfil_id') ? 'selected="selected"' : ''}}        
          <option value="{{$perfil->id}}" {{$selected}}?>  
            {{$perfil->descricao}}            
          </option>  
        @endforeach      
      </select>
    </div>         

  	<button type="submit" class="btn btn-primary" id="btnSalvar">  
      Salvar
    </button>
  </form>    
  <script type="text/javascript" 
          src="{{asset('/js/validacoes/admin/usuario.js')}}">
  </script>     
  
  <script type="text/javascript" 
          src="{{asset('/js/mascaras/telefone.js')}}">
  </script>    
@stop()
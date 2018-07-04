@extends('layout.header')

@section('titulo')
  Cadastro de usuário
@stop()

@section('conteudo')  
  <form action={!! route('usuario.salvar') !!} method="POST">  	
    
    {{csrf_field()}}

    <div class="form-group">
  	  <label for="nome_completo">Nome Completo</label>	
  	  <input type="text" name="nome_completo" class="form-control" 
             minlength="7" maxlength="70"    
  	         placeholder="Informe o nome completo do usuário" id="nome_completo" required>
  	</div>

  	<div class="form-group">
  	  <label for="usuario">Usuário</label>	
  	  <input type="text" name="usuario" class="form-control" minlength="7" maxlength="7"    
  	         placeholder="Informe o login de acesso para o usuário" id="usuario" required>
  	</div>

  	<div class="form-group">
  	  <label for="senha">Senha</label>	
  	  <input type="password" name="senha" class="form-control" minlength="5" maxlength="8"   
  	         placeholder="Informe uma senha para o usuário" id="senha" required>
  	</div>

  	<div class="form-group">
  	  <label for="senha2">Confirme a Senha</label>	
  	  <input type="password" name="senhaConf" class="form-control" minlength="5" 
             maxlength="8" 
             placeholder="Confirme a senha para o usuário" id="senhaConf" required>
  	</div>
    
  	<div class="form-group">
  	  <label for="email">Email</label>	
  	  <input type="email" name="email" class="form-control" minlength="13" maxlength="60"    
  	         placeholder="Informe um email do usuário" id="email" 
             pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" required>  	         
  	         
  	</div>    

  	<div class="form-group">
  	  <label for="telefone">Telefone</label>	
  	  <input type="tel" name="telefone" class="form-control" id="telefone"  
             placeholder="(99)99999-9999"   	         
             maxlength="15" 
             pattern="\([0-9]{2}\)[\s][0-9]{4,5}-[0-9]{4}" required 
             onkeyup="setMascara( this, getMascara );">
  	</div>

  	<button type="submit" class="btn btn-primary">Salvar</button>
  </form>  
  <script type="text/javascript" src="/js/mascaras/telefone.js"></script>
  <script type="text/javascript" src="/js/validacoes/msgRequired.js"></script>  
@stop()
@extends('layout.header')

@section('titulo')
  Cadastro de usuário
@stop()

@section('conteudo')  
  <form>
  	<div class="form-group">
  	  <label for="nome_completo">Nome Completo</label>	
  	  <input type="text" name="nome_completo" class="form-control" min="7" max="70"    
  	         placeholder="Informe o nome completo do usuário" id="nome_completo">
  	</div>

  	<div class="form-group">
  	  <label for="usuario">Usuário</label>	
  	  <input type="text" name="usuario" class="form-control" min="7" max="7"    
  	         placeholder="Informe o login de acesso para o usuário" id="usuario">
  	</div>

  	<div class="form-group">
  	  <label for="senha">Senha</label>	
  	  <input type="password" name="senha" class="form-control" min="5" max="8"    
  	         placeholder="Informe uma senha para o usuário" id="senha">
  	</div>

  	<div class="form-group">
  	  <label for="senha2">Confirme a Senha</label>	
  	  <input type="password" name="senha2" class="form-control" min="5" max="8"    
  	         placeholder="Confirme a senha para o usuário" id="senha2">
  	</div>
    
  	<div class="form-group">
  	  <label for="email">Email</label>	
  	  <input type="email" name="email" class="form-control" min="13" max="60"    
  	         placeholder="Informe um email do usuário" id="email">  	         
  	         
  	</div>    

  	<div class="form-group">
  	  <label for="telefone">Telefone</label>	
  	  <input type="tel" name="telefone" class="form-control" id="telefone"  
             placeholder="(99)99999-9999" 
  	         pattern="\([0-9]{2}\)[\s][0-9]{4,5}-[0-9]{4}" 
             maxlength="15" 
             onkeyup="setMascara( this, getMascara );">
  	</div>

  	<button type="submit">Enviar</button>
  </form>  
  <script type="text/javascript" src="/js/mascaraTelefone.js"></script>
@stop()